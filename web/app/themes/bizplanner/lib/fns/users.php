<?php
namespace BizPlanner\users;

/**
 * Retrieves a user's currently active business plan.
 *
 * @return     bool  The current business plan.
 */
function get_current_business_plan(){
  global $post;

  $current_business_plan = null;
  $business_plan_id = null;

  $current_user_id = get_current_user_id();
  if( ! $current_user_id )
    return false;

  if( isset( $_COOKIE['bpid'] ) && is_numeric( $_COOKIE['bpid'] ) && 'business-plan' == get_post_type( $_COOKIE['bpid'] ) ){
    $business_plan_post = get_post( $_COOKIE['bpid'] );
    if( $current_user_id == $business_plan_post->post_author )
      $business_plan_id = $_COOKIE['bpid'];
  } else {
    return false;
  }

  $business_plan = get_fields( $business_plan_id );
  //uber_log( '🔔 Here are the fields for a business plan: ' . print_r( $business_plan, true ) );

  /**
   * Set the array key for options with a single value to be equal to the option's term_id
   */
  $set_single_term_id_as_array_key = [ 'product_category' ];
  foreach( $set_single_term_id_as_array_key as $term_name ){
    if( is_array( $business_plan ) && array_key_exists( $term_name, $business_plan ) && is_object( $business_plan[$term_name] ) )
      $business_plan[$term_name] = [ $business_plan[$term_name]->term_id => $business_plan[$term_name] ];
  }

  /**
   * Set the array key for these selected options equal to the option's term_id
   */
  $set_term_ids_as_array_keys = [ 'marketing_methods', 'customers', 'management_team', 'sales_and_marketing_team', 'retail_sale', 'direct_sale', 'production_methods', 'company_facility', 'startup_funding_source' ];

  /**
   * Inclue any terms with an ACF `cost` custom field
   */
  $terms_with_costs = [ 'marketing_methods' => 0, 'company_facility' => 0, 'management_team' => 0, 'startup_funding_source' => 0 ];

  foreach( $set_term_ids_as_array_keys as $term_name ){
    if( is_array( $business_plan ) && array_key_exists( $term_name, $business_plan ) && is_array( $business_plan[ $term_name ] ) ){
      $$term_name = [];
      foreach( $business_plan[ $term_name ] as $term ){
        if( is_object( $term ) && property_exists( $term, 'term_id' ) ){

          // Get the cost of the term if available:
          if( array_key_exists( $term_name, $terms_with_costs ) && ( $cost = get_field( 'cost', $term ) ) ){
            $term->cost = $cost;
            $terms_with_costs[ $term_name ] += $cost;
          }

          $$term_name[$term->term_id] = $term;
        } else {
          $$term_name[] = $term;
        }
      }
      $business_plan[ $term_name ] = $$term_name;
      if( array_key_exists( $term_name, $terms_with_costs ) )
        $business_plan[ $term_name . '_cost' ] = $terms_with_costs[ $term_name ];
    } else {
      $business_plan[ $term_name . '_cost' ] = 0;
    }
  }

  $business_plan['ID'] = $business_plan_id;
  $business_plan['title'] = get_the_title( $business_plan_id );

  // Get User meta
  $user_meta_fields = ['school','grade','avatar'];
  foreach( $user_meta_fields as $meta_field ){
    $business_plan['user'][ $meta_field ] = get_user_meta( $current_user_id, $meta_field, true );
  }
  if( empty( $business_plan['user']['avatar'] ) )
    $business_plan['user']['avatar'] = 0;

  // Ensure all properties are initialized:
  $business_plan_properties = [ 'ID', 'company_name', 'product', 'product_description', 'product_category', 'marketing_methods', 'production_methods', 'company_facility', 'startup_funding_source' ];
  foreach( $business_plan_properties as $prop ){
    if( ! array_key_exists( $prop, $business_plan ) )
      $business_plan[ $prop ] = null;
  }

  //uber_log( '🔔 PROCESSED $business_plan = ' . print_r( $business_plan, true ) );

  return $business_plan;
}

/**
 * Registers a new user in WordPress without requiring the user to enter an email address.
 *
 * 11/03/2023 (17:33) - possible way to do this w/o Elementor: https://gist.github.com/vishalbasnet23/1937b45be0ea73784cc5
 * - https://wordpress.org/plugins/ajax-login-and-registration-modal-popup/
 * - https://wordpress.org/plugins/login-with-ajax/ 👈 Nice docs. Looks promising.
 *
 * @param      object   $record   The form submission object
 * @param      object   $handler  The form handler
 *
 * @return     boolean  Returns `true` when new user is created.
 */
function register_user( $record, $handler ){
  // Only process the form named `wordpress_user_registration`:
  $form_name = $record->get_form_settings( 'form_name' );
  if( 'wordpress_user_registration' != $form_name )
    return;

  uber_log('🔔 Processing `wordpress_user_registration`...');

  // Get our form field values
  $raw_fields = $record->get( 'fields' );
  $fields = [];
  uber_log( '🔔 $raw_fields = ' . print_r( $raw_fields, true ) );
  foreach( $raw_fields as $id => $field ){
    switch( $id ){
      /*
      case 'password':
      case 'postId':
        $$id = $field['value'];
        break;
      /**/

      default:
        $fields[$id] = $field['value'];
    }

  }
  uber_log( '🔔 $fields = ' . print_r( $fields, true ) );

  // Validate our data
  $required_fields = ['fname','lname','grade','school','username','password'];
  foreach ($required_fields as $value) {
    if( empty( $fields[ $value ] ) ){
      $handler->messages = [
        'error' => 'All fields are required. Please make sure you enter values for each field.',
      ];
      return false;
    }
  }

  if( username_exists( $fields['username'] ) ){
    $handler->messages = [
      'error' => 'Please choose a different username. A user with that username exists.',
    ];
    return false;
  }

  if( 4 >= strlen( $fields['password'] ) ){
    $handler->messages = [
      'error' => 'Your password must be five or more characters.',
    ];
    return false;
  }



  // Build a fake email address from the submitted username
  $user_email = $fields['username'] . '@bizplanner.dev';
  uber_log( '🔔 $user_email = '. $user_email);
  if( ! is_email( $user_email ) ){
    $handler->messages = [
      'error' => 'Please correct your username to use only letters and numbers.',
    ];
    return false;
  }
  $user_args = [
    'user_pass'     => $fields['password'],
    'user_login'    => $fields['username'],
    'user_email'    => $user_email,
    'display_name'  => $fields['username'],
    'first_name'    => $fields['fname'],
    'last_name'     => $fields['lname'],
    'meta_input' => [
      'school'  => $fields['school'],
      'grade'   => $fields['grade'],
    ],
  ];
  uber_log( '🔔 $user_args = ' . print_r( $user_args, true ) );
  // Add the user to WordPress
  if( ! email_exists( $user_email ) && ! username_exists( $fields['username'] ) ){


    $user_id = wp_insert_user( $user_args );
    wp_signon( [ 'user_login' => $fields['username'], 'user_password' => $fields['password'], 'remember' => false ] );
    return true;
  } else {
    uber_log('🔔 A user with the email `' . $user_email . '` already exists!' );
    return false;
  }
}
add_action( 'elementor_pro/forms/new_record', __NAMESPACE__ . '\\register_user', 10, 2 );

/**
 * Only return business plans that belong to the currently logged in user.
 *
 * @param      object  $query  The query object
 */
function filter_business_plans_query( $query ){
  $current_user = wp_get_current_user();
  $query->set( 'author', $current_user->ID );
}
add_action( 'elementor/query/current_user_business_plans', __NAMESPACE__ . '\\filter_business_plans_query' );

/**
 * Validates the User Registration fortm.
 *
 * @param      object  $record   The record
 * @param      object  $handler  The handler
 *
 * @return     bool    Returns `false` if global constants are not in the system.
 */
function validate_user_registration( $record, $handler ){
  // Only process the form named `wordpress_user_registration`:
  $form_name = $record->get_form_settings( 'form_name' );
  if( 'wordpress_user_registration' != $form_name )
    return;

  $username_field = $record->get_field( ['id' => 'username'] );
  $password_field = $record->get_field( ['id' => 'password'] );

  if( username_exists( $username_field['username']['value'] ) ){
    $handler->add_error( $username_field['username']['id'], 'Another user already has that username. Please use a different one. (Hint: Try adding a number or more letters.' );
  }

  if( 5 > strlen( $password_field['password']['value'] ) ){
    $handler->add_error( $password_field['password']['id'], 'Your password must be at least 5 characters.' );
  }
}
add_action( 'elementor_pro/forms/validation', __NAMESPACE__ . '\\validate_user_registration', 10, 2 );

/**
 * Adds custom user meta fields.
 *
 * @param      object  $user   The user
 */
function add_custom_user_meta_fields($user) {
    ?>
    <h3><?php _e('Custom User Meta Fields', 'textdomain'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="school"><?php _e('School', 'textdomain'); ?></label></th>
            <td>
                <input type="text" name="school" id="school" value="<?php echo esc_attr(get_user_meta($user->ID, 'school', true)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('The student\'s school', 'textdomain'); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="grade"><?php _e('Grade', 'textdomain'); ?></label></th>
            <td>
                <input type="text" name="grade" id="grade" value="<?php echo esc_attr(get_user_meta($user->ID, 'grade', true)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('The student\'s grade.', 'textdomain'); ?></span>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', __NAMESPACE__ . '\\add_custom_user_meta_fields');
add_action('edit_user_profile', __NAMESPACE__ . '\\add_custom_user_meta_fields');

/**
 * Save custom fields when edited by admin.
 *
 * @param      int  $user_id  The user identifier
 */
function save_custom_user_meta_fields($user_id) {
    if (current_user_can('edit_user', $user_id)) {
        update_user_meta($user_id, 'school', sanitize_text_field($_POST['school']));
        update_user_meta($user_id, 'grade', sanitize_text_field($_POST['grade']));
    }
}
add_action('personal_options_update', __NAMESPACE__ . '\\save_custom_user_meta_fields');
add_action('edit_user_profile_update', __NAMESPACE__ . '\\save_custom_user_meta_fields');
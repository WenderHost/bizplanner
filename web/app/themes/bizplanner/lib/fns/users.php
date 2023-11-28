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

  $current_user = wp_get_current_user();
  if( ! $current_user )
    return false;
  $current_user_id = $current_user->ID;

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
  $business_plan['user']['firstname'] = $current_user->user_firstname;
  $business_plan['user']['lastname'] = $current_user->user_lastname;
  $user_meta_fields = ['school','grade','avatar'];
  foreach( $user_meta_fields as $meta_field ){
    $business_plan['user'][ $meta_field ] = get_user_meta( $current_user_id, $meta_field, true );
  }
  if( empty( $business_plan['user']['avatar'] ) )
    $business_plan['user']['avatar'] = 0;

  // Initialize taxonomies as `null`
  $array_properties = [ 'product_category', 'marketing_methods', 'production_methods', 'company_facility', 'startup_funding_source' ];
  foreach( $array_properties as $prop ){
    if( ! array_key_exists( $prop, $business_plan ) )
      $business_plan[ $prop ] = null;
  }

  // Initialize `string` properties as `null`
  $string_properties = [ 'company_name', 'product', 'product_description' ];
  foreach( $string_properties as $prop ){
    if( ! array_key_exists( $prop, $business_plan ) )
      $business_plan[ $prop ] = null;
  }

  // Initialize `numeric` properties with a value of "0"
  $numeric_properties = [ 'ID', 'production_costs', 'quantity' ];
  foreach( $numeric_properties as $prop ){
    if( ! array_key_exists( $prop, $business_plan ) )
      $business_plan[ $prop ] = 0;
  }

  // Initial Financial Plan vars
  $financial_plan_array_keys = ['cost_per_unit','revenue','material_costs','operating_expenses','production_costs','net_profit','profitable','cash_reserves','positive_cash_reserves'];
  foreach( $financial_plan_array_keys as $key ){
    $business_plan['financial_plan'][ $key ] = 0;
  }

  // Peform calculations for Financial Plan
  if( $business_plan['ID'] && is_numeric( $business_plan['ID'] ) ){
    $business_plan['financial_plan']['cost_per_unit'] = $business_plan['production_costs']; // This is a "kludge" due to our original spec having production_costs == cost_per_unit
    $business_plan['financial_plan']['revenue'] = ( array_key_exists( 'product_price', $business_plan ) && is_numeric( $business_plan['product_price'] ) && array_key_exists( 'quantity', $business_plan ) && is_numeric( $business_plan['quantity'] ) )? $business_plan['product_price'] * $business_plan['quantity'] : 0;
    $business_plan['financial_plan']['material_costs'] = ( array_key_exists( 'quantity', $business_plan ) && is_numeric( $business_plan['production_costs'] ) && is_numeric( $business_plan['quantity'] ) )? $business_plan['production_costs'] * $business_plan['quantity'] : 0;
    $business_plan['financial_plan']['operating_expenses'] = $business_plan['management_team_cost'] + $business_plan['marketing_methods_cost'];
    $business_plan['financial_plan']['production_costs'] = $business_plan['financial_plan']['material_costs'] + $business_plan['company_facility_cost'];
    $business_plan['financial_plan']['net_profit'] = floatval( $business_plan['financial_plan']['revenue'] - ( $business_plan['financial_plan']['production_costs'] + $business_plan['financial_plan']['operating_expenses'] ) );
    $business_plan['financial_plan']['profitable'] = ( 0 > $business_plan['financial_plan']['net_profit'] )? false : true ;
    $business_plan['financial_plan']['cash_reserves'] = $business_plan['financial_plan']['net_profit'] + $business_plan['startup_funding_source_cost'];
    $business_plan['financial_plan']['positive_cash_reserves'] = ( 0 > ( $business_plan['financial_plan']['net_profit'] + $business_plan['startup_funding_source_cost'] ))? false : true ;
  }
  //uber_log( '🔔 PROCESSED $business_plan = ' . print_r( $business_plan, true ) );

  return $business_plan;
}

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
        <tr>
            <th><label for="avatar"><?php _e('Avatar', 'textdomain'); ?></label></th>
            <td>
              <?php
              $avatar = get_user_meta($user->ID,'avatar',true);
              if( ! $avatar )
                $avatar = 0;
              ?>

                <img class="img-fluid" id="avatar" style="cursor: pointer; width: 128px;" src="<?= BP_DIR_URI ?>lib/img/bizplanner-avatar_<?= esc_attr($avatar) ?>.png" data-bs-toggle="modal" data-bs-target="#ExtralargeModal" /><br />
                <span class="description"><?php _e('The student\'s avatar.', 'textdomain'); ?></span>
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

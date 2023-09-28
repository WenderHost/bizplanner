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
  $set_term_ids_as_array_keys = [ 'marketing_methods', 'customers', 'management_team', 'sales_and_marketing_team' ];
  foreach( $set_term_ids_as_array_keys as $term_name ){
    if( is_array( $business_plan ) && array_key_exists( $term_name, $business_plan ) && is_array( $business_plan[ $term_name ] ) ){
      $$term_name = [];
      foreach( $business_plan[ $term_name ] as $term ){
        if( is_object( $term ) && property_exists( $term, 'term_id' ) ){
          $$term_name[$term->term_id] = $term;
        } else {
          $$term_name[] = $term;
        }
      }
      $business_plan[ $term_name ] = $$term_name;
    }
  }

  $business_plan['ID'] = $business_plan_id;
  $business_plan['title'] = get_the_title( $business_plan_id );

  // Ensure all properties are initialized:
  $business_plan_properties = [ 'ID', 'company_name', 'product', 'product_description', 'product_category', 'marketing_methods', ];
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
  if( empty( $fields['username'] ) || empty( $fields['password'] ) ){
    $handler->messages = [
      'error' => 'Please enter a username and a password. These fields can not be empty.',
    ];
    return false;
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
    'user_pass' => $fields['password'],
    'user_login' => $fields['username'],
    'user_email' => $user_email,
    'display_name' => $fields['username'],
  ];
  uber_log( '🔔 $user_args = ' . print_r( $user_args, true ) );
  // Add the user to WordPress
  if( ! email_exists( $user_email ) && ! username_exists( $fields['username'] ) ){


    $user_id = wp_insert_user( $user_args );
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
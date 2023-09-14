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

  $business_plan = get_field( 'business_plan', $business_plan_id );
  //uber_log( '🔔 RAW $business_plan = ' . print_r( $business_plan, true ) );

  //*
  if( is_array( $business_plan ) && array_key_exists( 'product_category', $business_plan ) && is_object( $business_plan['product_category'] ) )
    $business_plan['product_category'] = [ $business_plan['product_category']->term_id => $business_plan['product_category'] ];
  /**/

  //*
  if( is_array( $business_plan ) && array_key_exists( 'marketing_methods', $business_plan ) && is_array( $business_plan['marketing_methods'] ) ){
    $marketing_methods = [];
    foreach( $business_plan['marketing_methods'] as $term ){
      if( is_object( $term ) && property_exists( $term, 'term_id' ) ){
        $marketing_methods[$term->term_id] = $term;
      } else {
        $marketing_methods[] = $term;
      }
    }
    $business_plan['marketing_methods'] = $marketing_methods;
  }

  if( is_array( $business_plan ) && array_key_exists( 'customers', $business_plan ) && is_array( $business_plan['customers'] ) ){
    $customers = [];
    foreach( $business_plan['customers'] as $term ){
      if( is_object( $term ) && property_exists( $term, 'term_id' ) ){
        $customers[$term->term_id] = $term;
      } else {
        $customers[] = $term;
      }
    }
    $business_plan['customers'] = $customers;
  }
  /**/

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
 * Registers a new user in WordPress and sends the lead to ActiveCampaign
 *
 * @param      object   $record   The form submission object
 * @param      object   $handler  The form handler
 *
 * @return     boolean  Returns `true` when new user is created.
 */
function register_user( $record, $handler ){
  // Only process the form named `wordpress_and_campaign_registration`:
  $form_name = $record->get_form_settings( 'form_name' );
  if( 'wordpress_user_registration' != $form_name )
    return;

  uber_log('🔔 Processing `wordpress_user_registration`...');

  // Get our form field values
  $raw_fields = $record->get( 'fields' );
  $fields = [];
  foreach( $raw_fields as $id => $field ){
    switch( $id ){
      case 'password':
      case 'postId':
        $$id = $field['value'];
        break;

      default:
        $fields[$id] = $field['value'];
    }

  }

  // Validate our data
  if( ! is_email( $fields['email'] ) ){
    \uber_log('🚨 `email` is not an email! Exiting...');
    return false;
  }
  if( email_exists( $fields['email'] ) ){
    $handler->messages = [
      'error' => ['Registration not sent. A user with that email address already exists.'],
    ];
    return false;
  }

  // Add the user to WordPress
  if( ! email_exists( $fields['email'] ) && ! username_exists( $fields['email'] ) ){
    $user_id = wp_insert_user([
      'user_pass' => wp_generate_password( 8, false ),
      'user_login' => $fields['email'],
      'user_email' => $fields['email'],
      'display_name' => $fields['firstname'],
      'first_name' => $fields['firstname'],
      'last_name' => $fields['lastname'],
    ]);
    create_user_message( $user_id );
    return true;
  } else {
    uber_log('🔔 A user with the email `' . $fields['email'] . '` already exists!' );
    return false;
  }
}
add_action( 'elementor_pro/forms/new_record', __NAMESPACE__ . '\\register_user', 10, 2 );

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

  $email_field = $record->get_field([
    'id' => 'email',
  ]);

  if( email_exists( $email_field['email']['value'] ) ){
    $handler->add_error( $email_field['email']['id'], 'This email address is already in use in our system.' );
  }
}
add_action( 'elementor_pro/forms/validation', __NAMESPACE__ . '\\validate_user_registration', 10, 2 );
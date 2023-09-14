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
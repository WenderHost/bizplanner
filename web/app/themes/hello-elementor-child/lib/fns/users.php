<?php
namespace BizPlanner\users;

/**
 * Message sent to users after they submit the "Register" form.
 *
 * @param      int   $user_id  The user identifier
 *
 * @return     boolean  Returns FALSE if no user found by the provided ID.
 */
function create_user_message( $user_id ){
  $user = get_userdata( $user_id );

  if( ! $user )
    return false;

  // Get the "Create User Message Subject" from our ACF Options Page
  $create_user_message_subject = get_field( 'create_user_message_subject', 'option' );
  if( ! $create_user_message_subject || empty( $create_user_message_subject ) )
    $create_user_message_subject = 'Thank You for Registering with ' . get_bloginfo( 'name' );

  // Get the "Create User Message" from our ACF Options Page
  $create_user_message = get_field( 'create_user_message', 'option' );
  if( ! $create_user_message || empty( $create_user_message ) )
    $create_user_message = nl2br( "Dear {firstname},\n\nThank you for registering with {site_name}. We will review the details you provided and notify you once your account has been approved/disapproved.\n\nBest Regards,\nThe NCC Team" );

  // Replace any tokens in the message
  $search = ['{site_name}','{firstname}'];
  $replace = [ get_bloginfo( 'name' ), $user->first_name ];
  $create_user_message = str_replace( $search, $replace, $create_user_message );

  $headers[] = 'From: ' . get_bloginfo("name") . ' <' . get_bloginfo("admin_email") . '>' . "\r\n";
  $headers[] = 'Content-Type: text/html; charset=UTF-8';
  wp_mail($user->user_email, $create_user_message_subject, $create_user_message, $headers);
}

/**
 * Retrieves a user's currently active business plan.
 *
 * @return     bool  The current business plan.
 */
function get_current_business_plan(){
  $current_user_id = get_current_user_id();

  if( $current_user_id ){
    $current_business_plan = get_user_meta( $current_user_id, 'current_business_plan', true );
  }

  if( $current_business_plan && is_numeric( $current_business_plan ) ){
    $business_plan = get_field( 'business_plan', $current_business_plan );
  }

  if( is_array( $business_plan ) && array_key_exists( 'product_category', $business_plan ) && is_object( $business_plan['product_category'] ) )
    $business_plan['product_category'] = $business_plan['product_category']->name;

  if( is_array( $business_plan ) && array_key_exists( 'marketing_methods', $business_plan ) && is_array( $business_plan['marketing_methods'] ) ){
    $marketing_methods = [];
    foreach( $business_plan['marketing_methods'] as $term ){
      $marketing_methods[] = $term->name;
    }
    $business_plan['marketing_methods'] = implode(',', $marketing_methods );
  }

  uber_log( '$business_plan = ' . print_r( $business_plan, true ) );

  // Ensure all properties are initialized:
  $business_plan_properties = [ 'company_name', 'product', 'product_description', 'product_category', 'marketing_methods', ];
  foreach( $business_plan_properties as $prop ){
    if( ! array_key_exists( $prop, $business_plan ) )
      $business_plan[ $prop ] = null;
  }

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
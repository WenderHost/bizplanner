<?php
namespace BizPlanner\api;

/**
 * Logs in a user
 */
function login_user_api(){
  register_rest_route( BP_REST_NAMESPACE, BP_BIZPLAN_ROUTE . 'login', [
    'methods'   => 'POST,GET',
    'callback'  => function( \WP_REST_Request $request ){
      $status_code = 200;
      $response = new \stdClass();
      $parameters = $request->get_params();

      $nonce = $request->get_header('X-WP-Nonce');
      if( ! wp_verify_nonce( $nonce, 'wp_rest') )
        wp_send_json( ['message' => 'Invalid nonce.'], 403 );

      $username = $parameters['username'];
      $password = $parameters['password'];

      $user = wp_signon( [ 'user_login' => $username, 'user_password' => $password ] );
      if( is_wp_error( $user ) ){
        $err_codes = $user->get_error_codes();
        $errors = [];
        if ( in_array( 'invalid_username', $err_codes ) ) {
          $errors[] = 'Invalid username.';
        }
        if ( in_array( 'incorrect_password', $err_codes ) ) {
          $errors[] = 'The password you entered is incorrect.';
        }
        $response->message = '<p>Please correct the following errors:</p> <ul><li>' . implode('</li><li>', $errors ) . '</li></ul>';
        wp_send_json( $response, 403 );
      } else {
        $response->message = 'Success! You\'re logged in. Redirecting...';
        $response->data = [ 'redirect_url' => home_url() ];
        wp_send_json( $response, $status_code );
      }

    },
    'permission_callback' => '__return_true',
  ]);
}
add_action( 'rest_api_init', __NAMESPACE__ . '\\login_user_api' );

/**
 * Registers a user.
 */
function register_user_api(){
  register_rest_route( BP_REST_NAMESPACE, BP_BIZPLAN_ROUTE . 'register', [
    'methods' => 'POST,GET',
    'callback'  => function( \WP_REST_Request $request ){
      $status_code = 200;
      $parameters = $request->get_params();

      $nonce = $request->get_header('X-WP-Nonce');
      if( ! wp_verify_nonce( $nonce, 'wp_rest') )
        wp_send_json( [ 'message' => 'Invalid nonce.' ], 403 );

      // Build a fake email address from the submitted username
      $user_email = $parameters['username'] . '@bizplanner.dev';
      uber_log( '🔔 $user_email = '. $user_email);
      if( ! is_email( $user_email ) )
        wp_send_json( [ 'message' => 'Please correct your username to use only letters and numbers.' ], 403 );

      if( 0 == $parameters['avatar'] ){
        wp_send_json( ['message' => 'Don\'t forget to pick Your Avatar.' ], 403 );
      }
      $avatar = 1;
      if( array_key_exists( 'avatar', $parameters ) && is_numeric( $parameters['avatar'] ) )
        $avatar = $parameters['avatar'];

      $user_args = [
        'user_pass'     => $parameters['password'],
        'user_login'    => $parameters['username'],
        'user_email'    => $user_email,
        'display_name'  => $parameters['username'],
        'first_name'    => $parameters['fname'],
        'last_name'     => $parameters['lname'],
        'meta_input' => [
          'school'  => $parameters['school'],
          'grade'   => $parameters['grade'],
          'avatar'  => $avatar,
        ],
      ];
      if( ! email_exists( $user_email ) && ! username_exists( $parameters['username'] ) ){
        $user_id = wp_insert_user( $user_args );
        wp_signon( [ 'user_login' => $parameters['username'], 'user_password' => $parameters['password'], 'remember' => false ] );
        wp_send_json( ['redirect_url' => home_url(), 'message' => 'Success! You are now logged in. Redirecting...' ], 200 );
      } else if( email_exists( $user_email ) || username_exists( $parameters['username'] ) ) {
        wp_send_json( ['message' => 'That username is taken. Please pick a new one.' ], 403 );
      }
    },
    'permission_callback' => '__return_true',
  ]);
}
add_action( 'rest_api_init', __NAMESPACE__ . '\\register_user_api' );
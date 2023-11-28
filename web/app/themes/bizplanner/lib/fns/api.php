<?php

namespace BizPlanner\api;

/**
 * Registers the BizPlanner API.
 */
function register_bizplanner_api(){
  /**
   * Handles creating a `business-plan` CPT
   */
  register_rest_route( BP_REST_NAMESPACE, BP_BIZPLAN_ROUTE . 'create', [
    'methods'   => 'POST,GET',
    'callback'  => function (\WP_REST_Request $request) {
        $status_code = 200;
        $response = new \stdClass();
        $parameters = $request->get_params();
        $response->parameters = $parameters;
        $messages = [];

        $nonce = $request->get_header('X-WP-Nonce');
        if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
          $status_code = 403;
          $response->message = 'Invalid nonce.';
        } else {
            $current_user_id = get_current_user_id();
            $count_posts = count_user_posts($current_user_id, 'business-plan');
            // Increment the count by 1 and append it to the title
            $post_title = 'Business Plan #' . ($count_posts + 1);

            $post_id = wp_insert_post(array(
                'post_title'   => $post_title,
                'post_type'    => 'business-plan',
                'post_status'  => 'publish',
                'post_author'  => $current_user_id,
            ));

            if (is_wp_error($post_id)) {
                $status_code = 500;
                $response->message = $post_id->get_error_message();
            } else {
                $response->message = 'Business plan created successfully.';
                $response->post_id = $post_id;
            }
        }

        wp_send_json( $response, $status_code );
    },
    'permission_callback' => function() {
      return current_user_can( 'publish_business-plans' );
    },
  ]);


  /**
   * Handles reading a `business-plan` CPT
   */
  register_rest_route( BP_REST_NAMESPACE, BP_BIZPLAN_ROUTE . 'read',[
    'methods'   => 'GET,POST',
    'callback'  => function( \WP_REST_Request $request ){
      // CODE GOES HERE
    },
    'permission_callback' => function(){
      return current_user_can( 'read_business-plan' );
    },
  ]);

  /**
   * Handles updating a `business-plan` CPT
   */
  register_rest_route( BP_REST_NAMESPACE, BP_BIZPLAN_ROUTE . 'update',[
    'methods'   => 'GET,POST',
    'callback'  => function( \WP_REST_Request $request ){
      $status_code = 200;
      $response = new \stdClass();

      $parameters = $request->get_params();
      $response->parameters = $parameters;
      $messages = [];
      if( ! is_array( $parameters) )
        uber_log('🔔👉 $paramters is not an array.');

      $nonce = $request->get_header('X-WP-Nonce');
      if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
        $status_code = 403;
        $response->message = 'Invalid nonce.';
      } else {
        // Unsetting Fields
        // If we receive form parameters with only `field_name` set, we must
        // initialize the parameter for the actual field so we can run
        // save_parameter() with an empty value.
        if( array_key_exists( 'field_name', $parameters ) && ! array_key_exists( $parameters['field_name'], $parameters ) )
          $parameters[ $parameters['field_name'] ] = '';

        foreach ( $parameters as $parameter => $value ) {
          if( 'field_name' == $parameter )
            continue;

          $saved = save_parameter( $parameter, $value );
          if( is_wp_error( $saved ) && 'notupdated' != $saved->get_error_code() ){
            $status_code = 500;

            $response->message = $saved->get_error_message();
            // '$saved->get_error_message() = ' . $saved->get_error_message(). "\n" .
            uber_log( '$response = ' . print_r( $response, true ) );
          } else if( is_wp_error( $saved ) && 'notupdated' == $saved->get_error_code() ){
            $messages[] = '- No change to `' . $parameter . '`.' . "\n";
          } else if( $saved ){
            $messages[] = '- Saved `' . $parameter . '`.' . "\n";
          }
        }
        if( $messages )
          $response->message = implode( "\n", $messages );
      }
      wp_send_json( $response, $status_code );
    },
    'permission_callback' => function(){
      return current_user_can( 'edit_business-plan' );
    },
  ]);

  /**
   * Handles deleting a `business-plan` CPT
   */
  register_rest_route( BP_REST_NAMESPACE, BP_BIZPLAN_ROUTE . 'delete',[
    'methods'   => 'GET,POST',
    'callback'  => function( \WP_REST_Request $request ){
      // CODE GOES HERE
    },
    'permission_callback' => function(){
      return current_user_can( 'delete_business-plan' );
    },
  ]);
}
add_action( 'rest_api_init', __NAMESPACE__ . '\\register_bizplanner_api' );

/**
 * Saves a Question Form parameter.
 *
 * @param      string  $parameter  The parameter
 * @param      string  $value      The value
 *
 * @return     bool|WP_Error TRUE for success, WP_Error object upon failure.
 */
function save_parameter( $parameter = null, $value = null ){
  global $current_business_plan;
  $updated = false;
  uber_log('🔔 running save_parameter for `' . $parameter . '` with $value = ' . print_r( $value, true ) );
  if( is_null( $parameter ) )
    return new \WP_Error( 'nullparameter', __( 'Parameter is null.', 'bizplanner' ) );

  $logged_value = '';

  switch( $parameter ){
    case 'product_category':
      if( array_key_exists( 'ID', $current_business_plan ) && is_numeric( $current_business_plan['ID'] ) && 'business-plan' == get_post_type( $current_business_plan['ID'] ) ){
        if( is_array( $value ) )
          $value = $value[0];
        $term = get_term_by( 'term_id', $value, $parameter );
        $updated = update_field( $parameter, $term, $current_business_plan['ID'] );
      }
      break;

    default:
      $logged_value = ( is_array( $value ) )? print_r( $value, true ) : $value ;
      if( array_key_exists( 'ID', $current_business_plan ) && is_numeric( $current_business_plan['ID'] ) && 'business-plan' == get_post_type( $current_business_plan['ID'] ) ){
        uber_log('🔔 running update_field(' . $parameter . ', ' . print_r($value,true) . ', ' . $current_business_plan['ID'] . ' );' );
        $updated = update_field( $parameter, $value, $current_business_plan['ID'] );
      } else {
        return new \WP_Error( 'nocurrentbizplan', __( 'No current business plan found.', 'bizplanner' ) );
      }
  }
  if( ! $updated ){
    uber_log('Note to Developer: Have you mapped this value to the Business Plan CPT in the "Business Plan Options" ACF Field Group? Was attempting to run save_parameter( $parameter, $value ) with the following: ' . "\n - \$parameter = " . $parameter . "\n - \$value = " . $logged_value );
    return new \WP_Error( 'notupdated', __( 'Error: The value for `' . $parameter . '` was not updated.', 'bizplanner' ) );
  }

  return $updated;
}
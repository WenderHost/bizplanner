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
    'permission_callback' => '__return_true',
  ]);


  /**
   * Handles reading a `business-plan` CPT
   */
  register_rest_route( BP_REST_NAMESPACE, BP_BIZPLAN_ROUTE . 'read',[
    'methods'   => 'GET,POST',
    'callback'  => function( \WP_REST_Request $request ){
      // CODE GOES HERE
    },
    'permission_callback' => '__return_true',
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
      foreach ( $parameters as $parameter => $value ) {
        $saved = save_parameter( $parameter, $value );
        if( is_wp_error( $saved ) ){
          $status_code = 500;

          $response->message = $saved->get_error_message();
          // '$saved->get_error_message() = ' . $saved->get_error_message(). "\n" .
          uber_log( '$response = ' . print_r( $response, true ) );
        } else if( $saved ){
          $messages[] = '- Saved `' . $parameter . '`.' . "\n";
        }
      }
      if( $messages )
        $response->message = implode( "\n", $messages );

      wp_send_json( $response, $status_code );
    },
    'permission_callback' => '__return_true',
  ]);


  /**
   * Handles deleting a `business-plan` CPT
   */
    register_rest_route(BP_REST_NAMESPACE, BP_BIZPLAN_ROUTE . 'delete/(?P<id>\d+)', [
        'methods'   => 'DELETE',
        'callback'  => function (\WP_REST_Request $request) {
            $status_code = 200;
            $response = new \stdClass();

            $nonce = $request->get_header('X-WP-Nonce');
            if (!wp_verify_nonce($nonce, 'wp_rest')) {
                $status_code = 403;
                $response->message = 'Invalid nonce.';
            } else {
                $id = $request->get_param('id');
                
                if (empty($id)) {
                    $status_code = 400;
                    $response->message = 'Invalid request. Please provide a valid ID.';
                } else {
                    // Check if the post exists and is of the 'business-plan' type
                    $post = get_post($id);
                    if (!$post || $post->post_type !== 'business-plan') {
                        $status_code = 404;
                        $response->message = 'Business plan not found.';
                    } else {
                        // Check if the current user has permission to delete the post
                        if (!current_user_can('delete_post', $id)) {
                            $status_code = 403;
                            $response->message = 'You do not have permission to delete this business plan.';
                        } else {
                            // Delete the business plan
                            if (wp_delete_post($id, true)) {
                                $response->message = 'Business plan deleted successfully.';
                            } else {
                                $status_code = 500;
                                $response->message = 'Failed to delete the business plan.';
                            }
                        }
                    }
                }
            }

            wp_send_json($response, $status_code);
        },
        'permission_callback' => '__return_true',
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

  if( is_null( $parameter ) )
    return new \WP_Error( 'nullparameter', __( 'Parameter is null.', 'bizplanner' ) );

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
        $updated = update_field( $parameter, $value, $current_business_plan['ID'] );
      } else {
        return new \WP_Error( 'nocurrentbizplan', __( 'No current business plan found.', 'bizplanner' ) );
      }
  }
  if( ! $updated )
    return new \WP_Error( 'notupdated', __( 'The value for `' . $parameter . '` was not updated. Was attempted to run save_parameter( $parameter, $value) with the following: ' . "\n - \$parameter = " . $parameter . "\n" . $logged_value, 'bizplanner' ) );

  return $updated;
}
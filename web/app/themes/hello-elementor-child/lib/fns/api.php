<?php

namespace BizPlanner\api;

function register_bizplanner_api(){
  register_rest_route( BP_REST_NAMESPACE, BP_BIZPLAN_ROUTE,[
    'methods'   => 'GET,POST',
    'callback'  => function( \WP_REST_Request $request ){
      $status_code = 200;
      $response = new \stdClass();

      $parameters = $request->get_params();
      $response->parameters = $parameters;
      $messages = [];
      foreach ($parameters as $parameter => $value ) {
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

      //return rest_ensure_response( $response );
      wp_send_json( $response, $status_code );
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
    case 'company_name':
    case 'customers':
    case 'product':
    case 'product_description':
    case 'product_price':
    case 'marketing_methods':
      if( array_key_exists( 'ID', $current_business_plan ) && is_numeric( $current_business_plan['ID'] ) && 'business-plan' == get_post_type( $current_business_plan['ID'] ) ){
        $updated = update_field( $parameter, $value, $current_business_plan['ID'] );
      } else {
        return new \WP_Error( 'nocurrentbizplan', __( 'No current business plan found.', 'bizplanner' ) );
      }
      break;

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
      uber_log( '🔔 save_parameter():' . "\n - \$parameter = " . $parameter . "\n" . $logged_value );
      return new \WP_Error( 'noparameterlogic', __( 'No logic found for saving `' . $parameter . '`.', 'bizplanner' ) );
  }
  if( ! $updated )
    return new \WP_Error( 'notupdated', __( 'The value for `' . $parameter . '` was not updated.', 'bizplanner' ) );

  return $updated;
}
<?php
namespace BizPlanner\shortcodes;

function get_business_plan_data( $atts ){
  global $post, $current_business_plan;

  // Don't run if ! $current_business_plan
  if(
    ( ! is_admin() && ! $current_business_plan ) ||
    ( ! is_admin() && is_array( $current_business_plan ) && ! array_key_exists( 'ID', $current_business_plan ) )
  ){
    wp_redirect( home_url(), 302 );
    exit;
  }

  $args = shortcode_atts([
    'value' => null,
  ], $atts );

  switch( $args['value'] ){
    default:
      if( ! is_null( $current_business_plan ) && array_key_exists( $args['value'], $current_business_plan ) && is_string( $current_business_plan[ $args['value'] ] ) ){
        $data = $current_business_plan[ $args['value'] ];
      } else {
        $data = 'No logic defined for <code>' . $args['value'] . '</code>.';
      }
      break;
  }

  return $data;
}
add_shortcode( 'bpdata', __NAMESPACE__ . '\\get_business_plan_data' );
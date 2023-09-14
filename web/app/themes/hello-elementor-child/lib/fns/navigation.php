<?php
namespace BizPlanner\navigation;

/**
 * Modifies the sidebar nav menu.
 *
 * @param      array  $items  The menu items
 * @param      array  $args   The menu arguments
 *
 * @return     array  The filtered menu items
 */
function modify_menu( $items, $args ) {
  foreach ( $items as $k => $object ) {
    $business_plan = BUSINESS_PLAN;
    $sanitized_title = str_replace( '-', '_', sanitize_title( $object->title ) );
    $icon = ( array_key_exists( $sanitized_title, $business_plan ) && ! empty( $business_plan[ $sanitized_title ] ) )? 'fa-check-circle' : 'fa-circle' ;
    $object->title = '<i class="fas ' . $icon . '"></i> ' . $object->title;
  }
  return $items;
}
add_filter( 'wp_nav_menu_objects', __NAMESPACE__ . '\\modify_menu', 10, 2 );
<?php
namespace BizPlanner\navigation;

/**
 * Modifies the question-sidebar nav menu.
 *
 * @param      array  $items  The menu items
 * @param      array  $args   The menu arguments
 *
 * @return     array  The filtered menu items
 */
function modify_menu( $items, $args ) {
  $sidebar_menu = get_field( 'sidebar_menu', 'option' );
  if( $sidebar_menu != $args->menu )
    return $items;

  $counter = 1;
  foreach ( $items as $k => $object ) {
    global $current_business_plan;
    $sanitized_title = str_replace( '-', '_', sanitize_title( $object->title ) );
    $icon = ( is_array( $current_business_plan ) && array_key_exists( $sanitized_title, $current_business_plan ) && ! empty( $current_business_plan[ $sanitized_title ] ) )? 'fa-check-circle' : 'fa-circle fa-regular' ;
    $object->title = '<i class="fas ' . $icon . '"></i> <span>' . $counter . '. ' . $object->title . '</span>';
    $counter++;
  }
  return $items;
}
add_filter( 'wp_nav_menu_objects', __NAMESPACE__ . '\\modify_menu', 10, 2 );
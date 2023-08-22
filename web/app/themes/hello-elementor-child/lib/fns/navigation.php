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
    $object->title = '<i class="fas fa-circle"></i> ' . $object->title; // fa-check-circle
  }
  return $items;
}
add_filter( 'wp_nav_menu_objects', __NAMESPACE__ . '\\modify_menu', 10, 2 );
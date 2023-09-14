<?php
namespace BizPlanner\acf;

/**
 * Loads available WP Menus as select options when the ACF Field is a Select field named `sidebar_menu`.
 *
 * @param      array  $field  The ACF field.
 *
 * @return     array  The field array with available WP Menus set as `choices`.
 */
function load_select_values( $field ) {
  $menus = wp_get_nav_menus();
  
  $field['choices'] = array();
  $field['choices'][0] = 'Select a menu to use in the sidebar...';
  foreach( $menus as $menu ) {
    $field['choices'][ $menu->slug ] = $menu->name;
  }
  
  return $field;
}
add_filter( 'acf/load_field/name=sidebar_menu', __NAMESPACE__ . '\\load_select_values' );

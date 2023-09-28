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


/**
 * Saves ACF configuration as JSON.
 *
 * @param      string  $path   The path
 *
 * @return     string  Returns ACF JSON save location.
 */
function acf_json_save_point( $path ) {
  return get_stylesheet_directory() . '/lib/acf-json';
}
add_filter('acf/settings/save_json', __NAMESPACE__ . '\\acf_json_save_point');

/**
 * Loads ACF configuration from JSON.
 *
 * @param      array  $paths  The paths
 *
 * @return     array  Array of ACF JSON locations.
 */
function acf_json_load_point( $paths ) {
    // remove original path
    unset($paths[0]);

    // append path
    $paths[] = get_stylesheet_directory() . '/lib/acf-json';

    // return
    return $paths;
}
add_filter('acf/settings/load_json', __NAMESPACE__ . '\\acf_json_load_point');
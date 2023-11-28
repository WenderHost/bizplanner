<?php
namespace BizPlanner\acf;

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
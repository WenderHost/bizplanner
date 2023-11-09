<?php

namespace BizPlanner\utilities;
use function BizPlanner\templates\{render_template};

/**
 * Returns an HTML alert message
 *
 * @param      array  $atts {
 *   @type  string  $type         The alert type can be primary, secondary, success, danger, warning, info, light, or dark (defaults to `primary`).
 *   @type  string  $title        The title of the alert.
 *   @type  string  $description  The content of the alert.
 *   @type  string  $css_classes  Additional CSS classes to add to the alert parent <div>.
 *   @type  bool    $dismissable  Is the alert dismissable? (default FALSE)
 * }
 *
 * @return     html  The alert.
 */
function get_alert( $atts ){
  $args = shortcode_atts([
   'type'               => 'primary', //
   'title'              => null,
   'description'        => 'Alert description goes here.',
   'css_classes'        => null,
   'dismissable'        => false,
  ], $atts );

  $args['dismissable'] = filter_var( $args['dismissable'], FILTER_VALIDATE_BOOLEAN );
  if( $args['dismissable'] )
    $args['css_classes'] = 'alert-dismissable';

  $data = [
    'description' => $args['description'],
    'title'       => $args['title'],
    'type'        => $args['type'],
    'css_classes' => $args['css_classes'],
    'dismissable' => $args['dismissable'],
  ];

  return render_template( 'alert', $data );
}
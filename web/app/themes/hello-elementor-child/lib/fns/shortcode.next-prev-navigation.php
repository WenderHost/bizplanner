<?php
namespace BizPlanner\shortcodes;
use function BizPlanner\templates\{render_template};

function get_next_prev_button( $atts ){
  $args = shortcode_atts([
    'type' => null,
  ], $atts );

  $type = ( is_null( $args['type'] ) || ! in_array( $args['type'], [ 'next', 'previous' ] ) )? 'previous' : $args['type'] ;

  global $post;
  $data = [];
  $question = get_field( $type . '_page', $post->ID );
  $data['url'] = ( $question )? get_the_permalink( $question ) : false ;
  $data['pagename'] = ( $question )? $question->post_title : false ;

  $html = render_template( $args['type'], $data );

  return $html;
}
add_shortcode( 'nextprev', __NAMESPACE__ . '\\get_next_prev_button' );
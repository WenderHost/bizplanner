<?php
namespace BizPlanner\shortcodes;
use function BizPlanner\templates\{render_template};
use function BizPlanner\question\{get_adjacent_question};

function get_next_prev_button( $atts ){
  $args = shortcode_atts([
    'type' => null,
  ], $atts );

  $type = ( is_null( $args['type'] ) || ! in_array( $args['type'], [ 'next', 'previous' ] ) )? 'previous' : $args['type'] ;


  global $post;
  $data = [];
  $data['next'] = ( 'next' == $type )? true : false ;
  //$question = get_field( $type . '_page', $post->ID );
  $previous = ( 'previous' == $type )? true : false ;
  $question = get_adjacent_question( $post->ID, $previous );
  if( ! $question ){
    $data['url'] = false;
    $data['pagename'] = false;
    $data['print_url'] = home_url( 'print-business-plan' );
  } else {
    $data['url'] = ( $question )? get_the_permalink( $question ) : false ;
    $data['pagename'] = ( $question )? $question->post_title : false ;
  }
  $html = render_template( 'next-prev', $data );

  return $html;
}
add_shortcode( 'nextprev', __NAMESPACE__ . '\\get_next_prev_button' );
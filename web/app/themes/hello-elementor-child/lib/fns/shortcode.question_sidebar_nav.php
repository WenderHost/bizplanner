<?php
namespace BizPlanner\shortcodes;
use function BizPlanner\utilities\{get_alert};
use function BizPlanner\templates\{render_template};

function get_question_sidebar_nav( $atts ){
  global $post, $current_business_plan;

  $questions = get_posts([
    'numberposts' => -1,
    'post_type'   => 'question',
    'order'       => 'ASC',
    'orderby'     => 'menu_order',
  ]);

  if( ! $questions )
    return get_alert([ 'description' => 'No Questions found! Please create some Questions to add to this menu.' ]);

  $data = [];
  $counter = 1;
  foreach ( $questions as $question ) {
    $sanitized_title = str_replace( '-', '_', sanitize_title( $question->post_name ) );
    $css_classes = ( is_array( $current_business_plan ) && array_key_exists( $sanitized_title, $current_business_plan ) && ! empty( $current_business_plan[ $sanitized_title ] ) )? 'fa-check-circle' : 'fa-circle fa-regular' ;

    $current = ( $post->ID == $question->ID )? 'current-menu-item' : null;
    $active = ( $post->ID == $question->ID )? 'elementor-item-active' : null;

    $data['questions'][] = [
      'title' => $question->post_title,
      'permalink' => get_the_permalink( $question->ID ),
      'classes'   => $css_classes,
      'counter'   => $counter,
      'current'   => $current,
      'active'    => $active,
    ];
    $counter++;
  }

  return render_template( 'sidebar-menu', $data );
}
add_shortcode( 'question_sidebar_nav', __NAMESPACE__ . '\\get_question_sidebar_nav' );
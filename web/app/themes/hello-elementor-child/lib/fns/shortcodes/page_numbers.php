<?php

namespace BizPlanner\shortcodes;

/**
 * Returns "{$question_title} • Page X of Y"
 *
 * @return     string  HTML for the current page indicator text.
 */
function page_numbers(){
  global $post;
  $current_page_no = $post->menu_order + 1;
  $questions_count = wp_count_posts( 'question' );
  $total_pages = $questions_count->publish;
  $current_title = $post->post_title;

  return '<div class="">' . $current_title . ' &bull; Page ' . $current_page_no . ' of ' . $total_pages . '</div>';
}
add_shortcode( 'page_numbers', __NAMESPACE__ . '\\page_numbers' );
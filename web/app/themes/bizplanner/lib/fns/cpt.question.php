<?php

namespace BizPlanner\question;

/**
 * Retrieves the Question CPT adjacent to the given question.
 */
function get_adjacent_question( $question_id = null, $previous = true ){
  if( is_null( $question_id ) )
    return false;
  $question = get_post( $question_id );
  $current_menu_order = $question->menu_order;

  $args = [
   'post_type' => 'question',
   'post_status' => 'publish',
   'menu_order' => null,
   'posts_per_page' => 1,
  ];

  if( $previous ){
    $args['menu_order'] = --$current_menu_order;
  } else {
    $args['menu_order'] = ++$current_menu_order;
  }

  if( -1 == $args['menu_order'] )
    return false;

  $query = new \WP_Query( $args );
  if( 0 < $query->post_count ){
    $adjacent_questions = $query->posts;
    return $adjacent_questions[0];
  } else {
    return false;
  }
}

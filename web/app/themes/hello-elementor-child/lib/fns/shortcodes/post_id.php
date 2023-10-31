<?php
namespace BizPlanner\shortcodes;

/**
 * A shortcode for returning the Post ID.
 *
 * @return     integer  The Post ID.
 */
function get_post_id(){
  global $post;
  return $post->ID;
}
add_shortcode( 'post_id', __NAMESPACE__ . '\\get_post_id' );
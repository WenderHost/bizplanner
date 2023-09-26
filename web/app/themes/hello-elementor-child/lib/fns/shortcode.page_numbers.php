<?php

namespace BizPlanner\shortcodes;

function page_numbers(){
  global $post;
  $sidebar_menu = get_field( 'sidebar_menu', 'option' );
  $menu_items = wp_get_nav_menu_items( $sidebar_menu );

  $total_pages = count( $menu_items );
  $counter = 1;
  $current_page_no = 0;
  $current_title = null;
  foreach( $menu_items as $item ){
    if( $post->post_title == $item->title ){
      $current_title = $item->title;
      $current_page_no = $counter;
    }
    $counter++;
  }
  //$post_obj_html = '<pre>'. print_r( $post, true ).'</pre>' . '<p><pre style="color: #d9d9d9;">'.print_r($menu_items,true).'</pre></p>';
  return '<div class="">' . $current_title . ' &bull; Page ' . $current_page_no . ' of ' . $total_pages . '</div>';

  //return '<p><pre style="color: #d9d9d9;">'.print_r($menu_items,true).'</pre></p>';
}
add_shortcode( 'page_numbers', __NAMESPACE__ . '\\page_numbers' );
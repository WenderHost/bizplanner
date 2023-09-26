<?php
namespace BizPlanner\shortcodes;

function title_bar(){
  global $current_business_plan;
  $title = ( is_array( $current_business_plan ) && array_key_exists( 'title', $current_business_plan ) )? $current_business_plan['title'] : 'Business Plan #1';
  return '<style>.title-bar span{font-family: "Segoe UI",Roboto,Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji"; font-weight: 500;}</style><div class="title-bar">Currently editing: <span>' . $title . '</span></div>';
}
add_shortcode( 'title_bar', __NAMESPACE__ . '\\title_bar' );
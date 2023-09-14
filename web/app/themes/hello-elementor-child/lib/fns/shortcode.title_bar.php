<?php
namespace BizPlanner\shortcodes;

function title_bar(){
  global $current_business_plan;
  return '<style>.title-bar span{font-family: "Segoe UI",Roboto,Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji"; font-weight: 500;}</style><div class="title-bar">Currently editing: <span>' . $current_business_plan['title'] . '</span></div>';
}
add_shortcode( 'title_bar', __NAMESPACE__ . '\\title_bar' );
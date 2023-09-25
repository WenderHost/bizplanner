<?php
namespace BizPlanner\shortcodes;

/**
 * Shows the New Business Plan button when the user has not
 * created a Business Plan or the user's Business Plans
 * loaded in a grid layout.
 *
 * @return     string  HTML for the shortcode
 */
function new_business_plan_button(){
  $current_user_id = get_current_user_id();

  if( $current_user_id ){
    $posts = get_posts([
      'post_type'       => 'business-plan',
      'posts_per_page'  => 1,
      'author'          => $current_user_id,
    ]);

    if( ! $posts ){
      return '<p style="color: #D9D9D9; margin-bottom: 1.5em;">Click the button below to get started:</p><div style="max-width: 450px; margin: 0 auto;">' . do_shortcode( '[elementor-template id="254"]' ) . '</div>';
    } else {
      return '<p style="color: #D9D9D9; margin-bottom: 1.5em;">Select a business plan below:</p>' . do_shortcode( '[elementor-template id="331"]' );
    }
  } else {
    return '<p>User is not logged in.</p>';
  }
}
add_shortcode( 'new_business_plan_button', __NAMESPACE__ . '\\new_business_plan_button' );
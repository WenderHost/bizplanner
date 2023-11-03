<?php
namespace BizPlanner\shortcodes;
use function BizPlanner\templates\{render_template};

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
      'posts_per_page'  => 3,
      'author'          => $current_user_id,
    ]);

    $data = [ 'one' => 'Testing' ];
    $bp = [];
    foreach( $posts as $post ){
      $bp[] = [
        'ID'  => $post->ID,
        'title'   => get_the_title( $post ),
        'company_name' => get_field( 'company_name', $post ),
        'product' => get_field( 'product', $post ),
        'view_url'  => home_url( 'view/' ),
        'edit_url'  => home_url( 'question/company-name/' ),
      ];
    }
    $repeat_empty = ( 3 - count( $bp ) );
    $data['show_empty_1'] = ( 2 > count( $bp ) )? true : false ;
    $data['show_empty_2'] = ( 1 > count( $bp ) )? true : false ;

    $data['show_add_new'] = ( 3 > count( $bp ) )? true : false ;
    $data['bp'] = $bp;

    $html = render_template( 'three-columns', $data );
    return '<p style="color: #D9D9D9; margin-bottom: 1.5em;">Select a business plan below:</p>' . $html;
  } else {
    return '<p>User is not logged in.</p>';
  }
}
add_shortcode( 'new_business_plan_button', __NAMESPACE__ . '\\new_business_plan_button' );
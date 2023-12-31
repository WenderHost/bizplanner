<?php
namespace BizPlanner\enqueues;
use function BizPlanner\question\{get_adjacent_question};

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function enqueue_scripts_styles() {
  $main_css = ( 'development' != BP_ENV )? 'dist/main.css' : 'main.css' ;
  wp_enqueue_style( 'bizplanner', get_stylesheet_directory_uri() . '/lib/css/' . $main_css, null, filemtime( get_stylesheet_directory() . '/lib/css/' . $main_css ) );

  wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/f4de4ed03f.js', null, '1.0.0', false );

  $bizplanner_js = ( 'development' != BP_ENV )? 'bizplanner-dist.js' : 'bizplanner.js' ;
  wp_enqueue_script( 'bizplanner', get_stylesheet_directory_uri() . '/lib/js/' . $bizplanner_js, null, filemtime( dirname( __FILE__ ) . '/../js/' . $bizplanner_js ), true );
  // Localize the bizplanner script and provide the BPID:
  $bpid = ( isset( $_COOKIE['bpid'] ) && is_numeric( $_COOKIE['bpid'] ) )? $_COOKIE['bpid'] : null ;
  $previous_question_url = null;
  $next_question_url = null;
  if( is_single() && 'question' == get_post_type() ){
    global $post;
    $previous = get_adjacent_question( $post->ID, true );
    $previous_question_url = get_the_permalink( $previous );
    $next = get_adjacent_question( $post->ID, false );
    $next_question_url = get_the_permalink( $next );
  }
  wp_localize_script( 'bizplanner', 'bpapi', [
    'endpoint'              => rest_url( BP_REST_NAMESPACE . BP_BIZPLAN_ROUTE ),
    'bpid'                  => $bpid,
    'nonce'                 => wp_create_nonce('wp_rest'),
    'themedir'              => BP_DIR_URI,
    'previous_question_url' => $previous_question_url,
    'next_question_url'     => $next_question_url,
  ]);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts_styles', 20 );

function dequeue_jquery_migrate( $scripts ) {
    if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff(
            $scripts->registered['jquery']->deps,
            [ 'jquery-migrate' ]
        );
    }
}
add_action( 'wp_default_scripts', __NAMESPACE__ . '\\dequeue_jquery_migrate' );
<?php

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {
  wp_enqueue_style( 'hello-elementor-child-style', get_stylesheet_directory_uri() . '/style.css', [ 'hello-elementor-theme-style' ], HELLO_ELEMENTOR_CHILD_VERSION );
  wp_enqueue_style( 'bizplanner', get_stylesheet_directory_uri() . '/lib/css/main.css', null, filemtime( get_stylesheet_directory() . '/lib/css/main.css') );
  wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/f4de4ed03f.js', null, '1.0.0', false );

  wp_enqueue_script( 'bizplanner', get_stylesheet_directory_uri() . '/lib/js/bizplanner.js', null, filemtime( dirname( __FILE__ ) . '/../js/bizplanner.js' ) );
  // Localize the bizplanner script and provide the BPID:
  $bpid = ( isset( $_COOKIE['bpid'] ) && is_numeric( $_COOKIE['bpid'] ) )? $_COOKIE['bpid'] : null ;
  wp_localize_script( 'bizplanner', 'bpapi', [
    'endpoint' => rest_url( BP_REST_NAMESPACE . BP_BIZPLAN_ROUTE ),
    'bpid'      => $bpid,
    'nonce' => wp_create_nonce('wp_rest'),
  ]);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

function dequeue_jquery_migrate( $scripts ) {
    if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff(
            $scripts->registered['jquery']->deps,
            [ 'jquery-migrate' ]
        );
    }
}
add_action( 'wp_default_scripts', 'dequeue_jquery_migrate' );
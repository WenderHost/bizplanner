<?php

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {
  wp_enqueue_style( 'hello-elementor-child-style', get_stylesheet_directory_uri() . '/style.css', [ 'hello-elementor-theme-style' ], HELLO_ELEMENTOR_CHILD_VERSION );

  wp_enqueue_script( 'bizplanner', get_stylesheet_directory_uri() . '/lib/js/bizplanner.js', null, filemtime( dirname( __FILE__ ) . '/../js/bizplanner.js' ) );
  // Localize the bizplanner script and provide the BPID:
  $bpid = ( isset( $_COOKIE['bpid'] ) && is_numeric( $_COOKIE['bpid'] ) )? $_COOKIE['bpid'] : null ;
  wp_localize_script( 'bizplanner', 'bpapi', [
    'endpoint' => rest_url( BP_REST_NAMESPACE . BP_BIZPLAN_ROUTE ),
    'bpid'      => $bpid,
  ]);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );
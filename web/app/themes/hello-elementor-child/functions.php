<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Include required files
 */
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/adminbar.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/debugging.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/enqueues.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/navigation.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/shortcode.question_form.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/users.php' );

define( 'BUSINESS_PLAN', BizPlanner\users\get_current_business_plan() );
uber_log( 'BUSINESS_PLAN = ' . print_r( BUSINESS_PLAN, true ) );

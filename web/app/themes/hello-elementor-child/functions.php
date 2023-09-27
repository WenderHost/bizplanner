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
define( 'BP_REST_NAMESPACE', 'bizplanner/v1' );
define( 'BP_BIZPLAN_ROUTE', '/bizplan/' );

/**
 * Include required files
 */
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/acf.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/adminbar.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/api.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/debugging.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/enqueues.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/navigation.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/shortcode.page_numbers.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/shortcode.post_id.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/shortcode.new_business_plan_button.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/shortcode.question_form.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/shortcode.title_bar.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/templates.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/users.php' );
require_once( get_stylesheet_directory( __FILE__ ) . '/lib/fns/utilities.php' );

if( ! is_admin() ){
  $current_business_plan = BizPlanner\users\get_current_business_plan();
  //uber_log( '$current_business_plan = ' . print_r( $current_business_plan, true ) );
}

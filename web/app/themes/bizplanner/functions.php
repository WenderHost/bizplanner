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
define( 'BP_DIR', trailingslashit( get_stylesheet_directory( __FILE__ ) ) );
define( 'BP_DIR_URI', trailingslashit( get_stylesheet_directory_uri( __FILE__ ) ) );

/**
 * Include required files
 */
require_once( BP_DIR . 'lib/fns/acf.php' );
require_once( BP_DIR . 'lib/fns/admin.php' );
require_once( BP_DIR . 'lib/fns/adminbar.php' );
require_once( BP_DIR . 'lib/fns/api.php' );
require_once( BP_DIR . 'lib/fns/api.user.php' );
require_once( BP_DIR . 'lib/fns/cpt.question.php' );
require_once( BP_DIR . 'lib/fns/debugging.php' );
require_once( BP_DIR . 'lib/fns/enqueues.php' );
require_once( BP_DIR . 'lib/fns/makepdf.php' );
//require_once( BP_DIR . 'lib/fns/navigation.php' );
require_once( BP_DIR . 'lib/fns/templates.php' );
require_once( BP_DIR . 'lib/fns/users.php' );
require_once( BP_DIR . 'lib/fns/utilities.php' );

/**
 * Shortcode includes for logic found in /lib/shortcodes/
 */
require_once( BP_DIR . 'lib/shortcodes/bpdata.php' );
//require_once( BP_DIR . 'lib/shortcodes/makepdf.php' );
require_once( BP_DIR . 'lib/shortcodes/new_business_plan_button.php' );
require_once( BP_DIR . 'lib/shortcodes/next-prev-navigation.php' );
require_once( BP_DIR . 'lib/shortcodes/page_numbers.php' );
require_once( BP_DIR . 'lib/shortcodes/post_id.php' );
require_once( BP_DIR . 'lib/shortcodes/question_form.php' );
require_once( BP_DIR . 'lib/shortcodes/question_sidebar_nav.php' );
require_once( BP_DIR . 'lib/shortcodes/title_bar.php' );

if( ! is_admin() ){
  $current_business_plan = BizPlanner\users\get_current_business_plan();
  //uber_log( '$current_business_plan = ' . print_r( $current_business_plan, true ) );
}

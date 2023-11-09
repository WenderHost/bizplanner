<?php
namespace BizPlanner\admin;

/**
 * Adds a menu order column.
 *
 * @param      array     $columns  The columns
 *
 * @return     array  The filtered columns for the admin listing.
 */
function add_menu_order_column( $columns ) {
  return array( 'menu_order' => '#' ) + $columns;
}
add_filter('manage_edit-question_columns', __NAMESPACE__ . '\\add_menu_order_column');

/**
 * Display the `menu_order` value in the custom column
 *
 * @param      string  $column   The column
 * @param      int     $post_id  The Post ID
 */
function display_menu_order_column( $column, $post_id ) {
  if ($column == 'menu_order') {
    $post = get_post( $post_id );
    echo esc_html( $post->menu_order ) . '.';
  }
}
add_action('manage_question_posts_custom_column', __NAMESPACE__ . '\\display_menu_order_column', 10, 2);

/**
 * Adds custom admin styles.
 */
function add_custom_admin_styles() {
    // Check if the current screen is 'edit.php' and the post type is 'question'
    if ( is_admin() && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'question' ) {
        // Enqueue your custom CSS file or add inline styles here
        wp_enqueue_style('custom-admin-styles', BP_DIR_URI . 'lib/css/custom-admin-styles.css');
    }
}
add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\add_custom_admin_styles');
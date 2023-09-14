<?php
namespace BizPlanner\adminbar;

/**
 * Removes the admin bar from Question CPT pages.
 */
function remove_admin_bar() {
  global $current_user;
  $user_roles = $current_user->roles;
  if( is_array( $user_roles ) && in_array( 'administrator', $user_roles ) )
    return;

  if (is_singular('question'))
    show_admin_bar(false);
}
add_action('wp', __NAMESPACE__ . '\\remove_admin_bar');

/**
 * Adds the current user's role as a CSS class to the <body/> tag.
 *
 * @param      array  $classes  The CSS classes to add to the <body/> tag
 *
 * @return     array  The filtered CSS classes
 */
function add_user_role_body_class($classes) {
    global $current_user;
    $user_roles = $current_user->roles;

    if ( is_array( $user_roles ) ) {
        foreach ( $user_roles as $role ) {
            $classes[] = 'user-role-' . $role;
        }
    }

    return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\add_user_role_body_class');


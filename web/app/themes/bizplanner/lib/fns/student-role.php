<?php

/**
 * Adds a custom user role called "Student".
 */
function add_student_role() {
  $business_plan_capabilities = [ 'edit_business-plan', 'read_business-plan', 'delete_business-plan', 'edit_published_business-plans', 'publish_business-plans', 'read_private_business-plans', 'edit_private_business-plans' ];

  if( ! get_role( 'student' ) ){
    add_role(
        'student',
        __('Student'),
        array(
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => false,
            'publish_posts' => true,
            'edit_published_posts' => true,
            'read_private_posts' => true,
            'edit_private_posts' => true,
        )
    );
    $student_role = get_role('student');
    $admin_role = get_role('administrator');
    $editor_role = get_role('editor');

    foreach( $business_plan_capabilities as $cap ){
      $student_role->add_cap( $cap );
      $admin_role->add_cap( $cap );
      $editor_role->add_cap( $cap );
    }
  }
}
add_action( 'after_switch_theme', 'add_student_role' );

/**
 * Removes a student role.
 */
function remove_student_role(){
  $student_role = get_role( 'student' );
  if( $student_role )
    remove_role( 'student' );
}
add_action( 'switch_theme', 'remove_student_role' );

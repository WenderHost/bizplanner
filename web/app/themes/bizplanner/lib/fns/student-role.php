<?php

// Add a custom user role called "Student"
function add_student_role() {
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
}
add_action('init', 'add_student_role');

// Add capabilities for the "business-plan" custom post type
function add_student_caps() {
    // Get the "Student" role
    $student_role = get_role('student');

    // Add capabilities for the "business-plan" CPT
    $student_role->add_cap('edit_business-plan');
    $student_role->add_cap('read_business-plan');
    $student_role->add_cap('delete_business-plan');
    $student_role->add_cap('edit_published_business-plans');
    $student_role->add_cap('publish_business-plans');
    $student_role->add_cap('read_private_business-plans');
    $student_role->add_cap('edit_private_business-plans');
}
add_action('init', 'add_student_caps');

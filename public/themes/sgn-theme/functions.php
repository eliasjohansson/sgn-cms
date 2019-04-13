<?php

declare (strict_types = 1);

// Register plugin helpers.
require template_path('includes/plugins/plate.php');

// Set theme defaults.
add_action('after_setup_theme', function () {
    // Disable the admin toolbar.
    show_admin_bar(false);

    // Add post thumbnails support.
    add_theme_support('post-thumbnails');

    // Add title tag theme support.
    add_theme_support('title-tag');

    // Add HTML5 theme support.
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'widgets',
    ]);

    // Register navigation menus.
    register_nav_menus([
        'navigation' => __('Navigation', 'wordplate'),
    ]);
});

// Enqueue and register scripts the right way.
add_action('wp_enqueue_scripts', function () {
    wp_deregister_script('jquery');

    // wp_enqueue_style('wordplate', mix('styles/app.css'));

    // wp_register_script('wordplate', mix('scripts/app.js'), '', '', true);
    // wp_enqueue_script('wordplate');
});

// Remove JPEG compression.
add_filter('jpeg_quality', function () {
    return 100;
}, 10, 2);

add_filter('pll_filter_query_excluded_query_vars', function ($excludes) {
    $excludes[] = 'allLanguages';
    return $excludes;
}, 3, 10);

// GRAPHQL

// Pages
require template_path('graphql/home.php');

add_filter('graphql_input_fields', function ($fields) {
    $fields['lang'] = [
        'type' => \WPGraphQL\Types::string(),
        'description' => 'Select posts by Polylang language',
    ];
    $fields['allLanguages'] = [
        'type' => \WPGraphQL\Types::boolean(),
        'description' => 'Show posts regardless of the Polylang language',
    ];
    /* $fields['template'] = [
    'type' => \WPGraphQL\Types::string(),
    'resolve' => function ($post) {
    if (!$template = get_page_template_slug($post->ID)) {
    return;
    }
    if (!$file = locate_template($template)) {
    return;
    }
    $data = get_file_data(
    $file,
    array(
    'Name' => 'Template Name',
    )
    );
    return $data["Name"];
    },
    ]; */
    return $fields;
});
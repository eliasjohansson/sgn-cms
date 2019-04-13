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
});

// Remove JPEG compression.
add_filter('jpeg_quality', function () {
    return 100;
}, 10, 2);

add_filter('pll_filter_query_excluded_query_vars', function ($excludes) {
    $excludes[] = 'allLanguages';
    return $excludes;
}, 3, 10);

// Hide default "Post" type
add_action('admin_menu', 'remove_default_post_type');

function remove_default_post_type()
{
    remove_menu_page('edit.php');
}

add_action('admin_bar_menu', 'remove_default_post_type_menu_bar', 999);

function remove_default_post_type_menu_bar($wp_admin_bar)
{
    $wp_admin_bar->remove_node('new-post');
}

add_action('wp_dashboard_setup', 'remove_draft_widget', 999);

function remove_draft_widget()
{
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
}

// Custom Post-types
add_action('init', function () {

    register_extended_post_type('branch', [
        "menu_icon" => "dashicons-networking",
        'show_in_graphql' => true,
        'graphql_single_name' => 'Branch',
        'graphql_plural_name' => 'Branches',
    ], [
        "singular" => "Branch",
        "plural" => "Branches",
    ]);

    register_extended_post_type('collaboration', [
        "menu_icon" => "dashicons-groups",
        'show_in_graphql' => true,
        'graphql_single_name' => 'Collaboration',
        'graphql_plural_name' => 'Collaborations',
    ], [
        "singular" => "Collaboration",
        "plural" => "Collaborations",
    ]);

    register_extended_post_type('news', [
        "menu_icon" => "dashicons-admin-site",
        'show_in_graphql' => true,
        'graphql_single_name' => 'NewsPost',
        'graphql_plural_name' => 'News',
    ], [
        "singular" => "News Post",
        "plural" => "News",
    ]);

});

// GRAPHQL
// Page Schemas
require template_path('graphql/home.php');

// Where clauses
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
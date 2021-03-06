<?php
declare (strict_types = 1);

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

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

// Allow .svg file type
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

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

    register_extended_post_type('event', [
        "menu_icon" => "dashicons-calendar-alt",
        'show_in_graphql' => true,
        'graphql_single_name' => 'Event',
        'graphql_plural_name' => 'Events',
    ], [
        "singular" => "Event",
        "plural" => "Events",
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

    register_extended_post_type('general', [
        "menu_icon" => "dashicons-translation",
        'show_in_graphql' => true,
        'graphql_single_name' => 'GeneralInfoTranslation',
        'graphql_plural_name' => 'GeneralInfoTranslations',
    ], [
        "singular" => "General Info & Translation",
        "plural" => "General Info & Translations",
    ]);

    /* register_extended_post_type('news', [
"menu_icon" => "dashicons-admin-site",
'show_in_graphql' => true,
'graphql_single_name' => 'NewsPost',
'graphql_plural_name' => 'News',
], [
"singular" => "News Post",
"plural" => "News",
]); */

});

// Translation for all custom post-types
add_filter('pll_get_post_types', 'add_cpt_to_pll', 10, 2);

function add_cpt_to_pll($post_types, $is_settings)
{
    if ($is_settings) {
        // hides 'my_cpt' from the list of custom post types in Polylang settings
        unset($post_types['branch']);
        unset($post_types['event']);
        unset($post_types['collaboration']);
        unset($post_types['general']);
        /* unset($post_types['news']); */
    } else {
        // enables language and translation management for 'my_cpt'
        $post_types['branch'] = 'branch';
        $post_types['event'] = 'event';
        $post_types['collaboration'] = 'collaboration';
        $post_types['general'] = 'general';
        /* $post_types['news'] = 'news'; */
    }
    return $post_types;
};

$langType = new ObjectType([
    'name' => 'Lang',
    'fields' => [
        'name' => Type::string(),
        'slug' => Type::string(),
        'locale' => Type::string(),
    ],
]);

// Create query to get all languages
register_graphql_field(
    'RootQuery',
    'languages',
    [
        'type' => Type::listOf($langType),
        'resolve' => function () {
            $langs = pll_the_languages(array('raw' => 1));
            return $langs;
        },
    ]
);

// Language field for pages
register_graphql_field(
    'Page',
    'language',
    [
        'type' => Type::string(),
        'resolve' => function ($post) {
            $lang = pll_get_post_language($post->ID);
            return $lang;
        },
    ]
);

// List of available translations for page
register_graphql_field(
    'Page',
    'availableLanguages',
    [
        'type' => Type::listOf(Type::string()),
        'resolve' => function ($post) {
            $langs = pll_get_post_translations($post->ID);
            return array_keys($langs);
        },
    ]
);

// GRAPHQL
// Component Schemas
require template_path('graphql/link-button.php');
require template_path('graphql/button.php');
require template_path('graphql/image.php');
require template_path('graphql/header.php');
require template_path('graphql/banner.php');
require template_path('graphql/tac.php');

// Page Schemas
require template_path('graphql/home.php');
require template_path('graphql/branches.php');
require template_path('graphql/collaborations.php');
require template_path('graphql/news.php');
require template_path('graphql/donate.php');
require template_path('graphql/membership.php');

// CPT Schemas
require template_path('graphql/cpt-event.php');
require template_path('graphql/cpt-branch.php');
require template_path('graphql/cpt-collaboration.php');
require template_path('graphql/cpt-general.php');

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
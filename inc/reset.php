<?php
/**
 * This file takes care of resetting and setting sensible theme feature defaults.
 * It generally does not need to be edited for individual themes!
 */

namespace KWIO\Theme;

add_action('admin_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library-theme');
});

// Clean up head and add default theme features.
add_action('after_setup_theme', function () {
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('editor-styles');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    remove_theme_support('core-block-patterns');

    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'feed_links', 2); // Remove line for blogs.
    remove_action('wp_head', 'feed_links_extra', 3); // Remove line for blogs.
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_site_icon', 99);
});

// Disable image down scaling during upload to preserve quality - espacially for jpgs.
add_filter('big_image_size_threshold', '__return_false');

// Remove layout settings from Gutenberg UI.
add_filter('block_type_metadata', function ($metadata) {
    if (isset($metadata['supports']['__experimentalLayout'])) {
        $metadata['supports']['__experimentalLayout'] = false;
    }

    return $metadata;
});

// Disable external block directory in Gutenberg UI.
remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
remove_action('enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory');

// Replace login logo link.
add_filter('login_headerurl', fn() => home_url());

// Disable WordPress default image sizes since we set different sizes per block view.
add_filter('max_srcset_image_width', fn() => 1);

add_filter('nav_menu_css_class', function ($classes, $item, $args) {
    $baseClass = $args->theme_location ?? 'navigation';

    return array_map(function ($class) use ($baseClass) {
        $baseClassContainsUnderscore = strpos($baseClass, '__') > -1;

        if ($class === 'menu-item') {
            return $baseClass . ($baseClassContainsUnderscore ? '-item' : '__item');
        }

        if ($class === 'menu-item-has-children') {
            return 'has-children';
        }

        if (in_array($class, ['current-menu-item', 'current-menu-ancestor', 'current-page-ancestor', 'current_page_ancestor'])) {
            return 'is-active';
        }

        return $class;
    }, $classes);
}, 10, 3);

add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    $baseClass = $args->theme_location ?? 'navigation';
    $baseClassContainsUnderscore = strpos($baseClass, '__') > -1;
    $atts['class'] = $baseClass . ($baseClassContainsUnderscore ? '-link' : '__link');

    return $atts;
}, 10, 3);

// Add defer attribute to all front end scripts.
add_filter('script_loader_tag', fn($tag) => !is_admin() ? str_replace(' src', ' defer="defer" src', $tag) : $tag);

// Only load core block styles which are rendered on the current page.
add_filter('should_load_separate_core_block_assets', '__return_true');

// Remove core block general and individual styles.
add_action('wp_enqueue_scripts', function () {
    foreach (['heading', 'list'] as $block) {
        wp_dequeue_style('wp-block-' . $block);
    }

    wp_dequeue_style('wp-block-library');
}, 11);

// Remove default color css variables and utility classes.
remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

// Re-add general utility classes.
add_action('wp_enqueue_scripts', function () {
    wp_register_style('global-styles', false, [], true, true);
	wp_add_inline_style('global-styles', wp_get_global_stylesheet(['styles']));
	wp_enqueue_style('global-styles');
}, 9);
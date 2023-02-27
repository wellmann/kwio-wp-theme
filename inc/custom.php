<?php
/**
 * This is the file for custom settings for individual themes.
 */

 namespace KWIO\Theme;

 add_action('after_setup_theme', function () {
    load_theme_textdomain('kwio-wp-theme', get_template_directory() . '/lang');

    register_nav_menus([
        'meta-nav' => __('Meta', 'kwio-wp-theme'),
        'primary-nav' => __('Primary', 'kwio-wp-theme'),
        'footer-nav' => __('Footer', 'kwio-wp-theme')
    ]);

    add_post_type_support('page', 'excerpt');
});

add_filter('wp_resource_hints', function ($urls, $relationType) {

    return $urls;
}, 10, 2);

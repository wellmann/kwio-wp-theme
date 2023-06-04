<?php
/**
 * This file takes care of loading build or static assets when placed into the appropriate folders.
 * It generally does not need to be edited for individual themes!
 */

namespace KWIO\Theme;

// Add custom login styles.
add_action('login_enqueue_scripts', function () {
    $loginStylesFile = get_dist_directory() . '/login.css';
    if (is_readable($loginStylesFile)) {
        $loginStyles = file_get_contents($loginStylesFile);
        $loginStyles = str_replace('../..', get_stylesheet_directory_uri(), $loginStyles);
        printf('<style>%s</style>', $loginStyles) . PHP_EOL;
    }
});

// Enqueue theme base styles.
add_action('wp_enqueue_scripts', function () {
    $criticalCssFile = get_dist_directory() . '/theme.critical.css';
    if (!is_readable($criticalCssFile)) {
        return;
    }

    wp_add_inline_style('kwio-wp-blocks', file_get_contents($criticalCssFile));
});

// Add preload link tags for woff2 web fonts.
add_action('wp_head', function () {
    $fonts = glob(get_stylesheet_directory() . '/static/fonts/*.woff2');
    foreach ($fonts as $font) {
        $fontUrl = str_replace(WP_CONTENT_DIR, WP_CONTENT_URL, $font);

        printf('<link rel="preload" href="%s" as="font" crossorigin>', $fontUrl) . PHP_EOL;
    }
}, 1);
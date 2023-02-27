<?php
/**
 * This file takes care of loading build or static assets when placed into the appropriate folders.
 * It generally does not need to be edited for individual themes!
 */

namespace KWIO\Theme;

// Add colors and font sizes to Gutenberg UI generated from SASS variables.
add_action('after_setup_theme', function () {
    $colorPaletteJson = get_dist_directory() . '/color-palette.json';
    if (is_readable($colorPaletteJson)) {
        add_theme_support('editor-color-palette', json_decode(file_get_contents($colorPaletteJson), true));
    }

    $fontSizesJson = get_dist_directory() . '/font-sizes.json';
    if (is_readable($fontSizesJson)) {
        $fontSizes = array_map(function ($value) {
            $value['size'] = $value['color'];
            unset($value['color']);

            return $value;
        }, json_decode(file_get_contents($fontSizesJson), true));

        add_theme_support('editor-font-sizes', $fontSizes);
    }
});

// Add custom login styles.
add_action('login_enqueue_scripts', function () {
    $loginStyles = get_dist_directory() . '/login.css';
    if (is_readable($loginStyles)) {
        $loginStyles = str_replace('../..', get_stylesheet_directory_uri(),  file_get_contents($loginStyles));
        echo '<style>' .$loginStyles . '</style>' . PHP_EOL;
    }
});

// Enqueue styles and scripts from build process.
add_action('wp_enqueue_scripts', function () {
    wp_add_inline_style(get_stylesheet() . '-blocks', file_get_contents(get_dist_directory() . '/theme.critical.css'));
});

// Add preload link tags for woff2 web fonts.
add_action('wp_head', function () {
    $fonts = glob(get_stylesheet_directory() . '/static/fonts/*.woff2');
    foreach ($fonts as $font) {
        $fontUrl = str_replace(WP_CONTENT_DIR, WP_CONTENT_URL, $font);

        echo '<link rel="preload" href="' . $fontUrl . '" as="font" crossorigin>' . "\n";
    }
}, 1);
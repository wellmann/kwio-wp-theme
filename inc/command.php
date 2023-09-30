<?php

namespace KWIO\Theme;

use WP_CLI;

// WP-CLI command to generate file with CSS variables from theme.json to help with IDE code completion.
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('kwio generate-theme-json-css-variables', function () {
        $filename = get_stylesheet_directory() . '/build/themeJson.css';
        $stylesheet = wp_get_global_stylesheet(['variables']);

        if (!file_put_contents($filename, $stylesheet)) {
            WP_CLI::error('Could not write file to ' . $filename);
        }

        WP_CLI::success('File written to ' . $filename);
    });
}
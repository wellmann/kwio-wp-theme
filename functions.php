<?php

namespace KWIO\Theme;

use KWIO\GutenbergBlocks\Loader;

if (file_exists(get_template_directory() . '/vendor/autoload.php')) {
    require get_template_directory() . '/vendor/autoload.php';
}

$blocksLoader = new Loader(__FILE__);
$blocksLoader
    ->loadBlocks('blocks/', __NAMESPACE__)
    ->setCategories([
        [
            'slug'  => 'content',
            'title' => 'Inhalt'
        ],
        [
            'slug'  => 'advanced',
            'title' => 'Fortgeschritten'
        ],
        [
            'slug'  => 'product',
            'title' => 'Produkt'
        ]
    ])
    ->init();
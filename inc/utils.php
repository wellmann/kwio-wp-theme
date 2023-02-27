<?php
/**
 * This is the file for utility functions.
 */

 namespace KWIO\Theme;

 function get_icon(string $icon, string $className = ''): string {
    $iconSpritePath = get_dist_directory() . '/images/icon-sprite.svg';
    if (!is_readable($iconSpritePath)) {
        return '';
    }

    $verHash  = substr(md5_file($iconSpritePath), 0, 12);

    return sprintf(
        '<svg %s aria-hidden="true" focusable="false"><use href="%s"/></svg>',
        !empty($className) ? sprintf('class="%s"', esc_attr($className)) : '',
        get_dist_directory_uri() . "/images/icon-sprite.svg?v=$verHash#" . $icon
    );
}

function get_dist_directory(): string {
    return  get_stylesheet_directory() . '/dist';
}

function get_dist_directory_uri(): string {
    return  get_stylesheet_directory_uri() . '/dist';
}

function get_image_alt(int $imageId): string {
    return get_post_meta($imageId, '_wp_attachment_image_alt', true) ?? '';
}

function get_image_caption(int $imageId): string {
    if (!$post = get_post($imageId)) {
        return '';
    }

    if ('attachment' !== $post->post_type) {
        return '';
    }

    return $post->post_content;
}

function get_nav_menu(string $themeLocation, array $args = []): string {
    return wp_nav_menu(
        array_merge([
            'menu_class' => "{$themeLocation}__list js-{$themeLocation}__list is-top-level",
            'container' => false,
            'theme_location' => $themeLocation,
            'items_wrap' => '<ul class="%2$s" id="' . $themeLocation . '__list">%3$s</ul>',
            'echo' => false
        ], $args)
    );
}

function get_nav_menu_items(string $themeLocation): array {
    $menuLocations = get_nav_menu_locations();
    $menuID = $menuLocations[$themeLocation] ?? 0;
    if (empty($menuID)) {
        return [];
    }

    $hierachicalItems = [];
    $items = wp_get_nav_menu_items($menuID);
    foreach ($items as $item) {
        $hierachicalItems = [
            'id' => $item->ID,
            'title' => $item->title,
            'url' => $item->url,
            'classes' => $item->classes,
            'children' => []
        ];

        if (!empty($item->menu_item_parent)) {
            $hierachicalItemss[$item->menu_item_parent]['children'][] = $hierachicalItems;
        } else {
            $hierachicalItemss[$item->ID] = $hierachicalItems;
        }
    }

    return $hierachicalItemss;
}

function render_block(string $blockSlugOrClassName, array $attrs = []): string {
    if (is_a($blockSlugOrClassName, BaseBlock::class, true)) {
        $blockSlugOrClassName = $blockSlugOrClassName::toSlug();
    }

    return \render_block([
        'blockName' => get_stylesheet() .'/' . $blockSlugOrClassName,
        'attrs' => $attrs
    ]);
}
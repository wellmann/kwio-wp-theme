<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?= __('Skip to content', 'kwio') ?></a>
<div class="wp-site-blocks">
<?= KWIO\Theme\render_block(Header::class) ?>
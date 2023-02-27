<?php

// Blocks need to be parsed before `wp_head` to load individual block CSS files in head.
$content = apply_filters('the_content', get_the_content());
?>

<?php get_header(); ?>
<main class="is-layout-constrained" id="content"><?= $content ?></main>
<?php get_footer(); ?>
<?php

namespace KWIO\Theme\Block;

use KWIO\GutenbergBlocks\BaseBlock;
use WP_Block;

class CoreGroup extends BaseBlock
{
    public function render(array $attributes, string $content, ?WP_Block $block = null): string
    {
        parent::render($attributes, $content);

        return $content;
    }
}
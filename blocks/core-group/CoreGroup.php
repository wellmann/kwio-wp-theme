<?php

namespace KWIO\Theme;

use KWIO\GutenbergBlocks\BaseBlock;
use WP_Block;

class CoreGroup extends BaseBlock
{
    public function render(array $attributes, string $content, ?WP_Block $block = null): string
    {
        parent::render($attributes, $content);

        if (!empty($attributes['align']) && $attributes['align'] === 'full') {
            $content = str_replace('alignfull', 'alignfull is-layout-constrained', $content);
        }

        return $content;
    }
}
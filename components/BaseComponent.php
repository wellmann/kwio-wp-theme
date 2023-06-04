<?php

declare(strict_types=1);

namespace KWIO\Theme\Component;

class BaseComponent
{
    protected string $dirPath;

    public function setDirPath(string $componentDirPath): void
    {
        $componentClassParts = explode('\\', static::class);
        $componentClass = array_pop($componentClassParts);
        $componentSlug = preg_replace('%([a-z])([A-Z])%', '$1-$2', $componentClass);
        $componentSlug = strtolower($componentSlug);

        $this->dirPath = $componentDirPath . $componentDirPath;
    }

    public function render(): string
    {
        $properties = get_object_vars($this);


    }

    protected function setView(): string
    {
        $cacheDir = WP_CONTENT_DIR . '/cache/kwio/theme/bade';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0775, true);
        }

        $blade = new BladeOne(
            dirname($filePath),
            $cacheDir,
            defined('WP_DEBUG') && WP_DEBUG === true ? BladeOne::MODE_DEBUG : BladeOne::MODE_AUTO
        );
    }
}
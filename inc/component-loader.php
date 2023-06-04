<?php

namespace KWIO\Theme;

$componentDirPath = dirname(__FILE__, 2) . '/components/';
$componentPaths = glob($componentDirPath . '*', GLOB_ONLYDIR);
foreach ($componentPaths as $componentPath) {
    $component = basename($componentPath);
    $componentClassName = str_replace('-', '', ucwords($block, '-'));
    $componentClassFilePath = $componentPath . $componentClassName . '.php';

    if (file_exists($componentClassFilePath)) {
        require_once $componentClassFilePath;
    }
}
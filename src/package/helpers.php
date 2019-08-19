<?php

namespace Vkovic\LaravelCommando;

/**
 * Get the path to the src folder
 *
 * @param  string $path
 *
 * @return string
 */
function src_path($path = '')
{
    $srcPath = rtrim(__DIR__, 'package');
    $srcPath = rtrim($srcPath, DIRECTORY_SEPARATOR);

    return $srcPath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}
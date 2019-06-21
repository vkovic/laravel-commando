<?php

if (!function_exists('src_path')) {
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
}

if (!function_exists('package_path')) {
    /**
     * Get the path to the package folder
     *
     * @param  string $path
     *
     * @return string
     */
    function package_path($path = '')
    {
        return src_path('package' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}
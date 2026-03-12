<?php

if (!function_exists('homeview_layout')) {

    function homeview_layout(array $parts = ['header','style','logo','script'])
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['file'] ?? __FILE__;
        $viewFolder = strtolower(basename(dirname($caller)));

        $root = defined('APPROOT') ? APPROOT : dirname(__DIR__, 2);
        $path = $root . "/Views/{$viewFolder}/includes/";

        foreach ($parts as $part) {
            $file = $path . $part . '.php';
            if (is_file($file)) {
                include $file;
            }
        }
    }

}
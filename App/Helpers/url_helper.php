<?php

if (!function_exists('base_url')) {
    /**
     * Returns the full URL based on the APP_URL (URLROOT) or auto-detected
     *
     * @param string $path Optional relative path
     * @return string Full URL
     */
    function base_url(string $path = ''): string
    {
        static $baseUrl = null;

        if ($baseUrl === null) {
            if (defined('URLROOT')) {
                $baseUrl = rtrim(URLROOT, '/');
            } else {
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                $host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
                $script   = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
                $baseUrl  = rtrim($protocol . '://' . $host . $script, '/');
            }
        }

        // Normalize the path and prevent directory traversal
        $path = ltrim(str_replace(['..', '\\'], '', $path), '/');

        return $baseUrl . ($path ? '/' . $path : '');
    }
}

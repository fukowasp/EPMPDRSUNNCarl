<?php

if (!function_exists('view_render')) {

    function view_render(string $view, array $data = []): void
    {
        // Normalize view path
        $view = trim($view, '/\\');
        $view = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $view);

        // Build full path
        $viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views'
                  . DIRECTORY_SEPARATOR . $view . '.php';

        // Validate file
        if (!is_file($viewPath)) {
            die("❌ View not found: {$view}");
        }

        // Inject authenticated user if available
        if (class_exists(\App\Helpers\Auth::class)) {
            $data['employee'] = \App\Helpers\Auth::user();
        }

        // Extract variables safely
        if (!empty($data)) {
            extract($data, EXTR_SKIP);
        }

        require $viewPath;
    }

}
<?php
if (!function_exists('view_render')) {
    function view_render(string $view, array $data = []): void
    {
        if (!is_array($data)) {
            $data = [];
        }

        if (class_exists(\App\Helpers\Auth::class)) {
            $data['employee'] = \App\Helpers\Auth::user();
        }

        $view = trim($view, '/\\');
        $view = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $view);

        $viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views'
                  . DIRECTORY_SEPARATOR . $view . '.php';

        $viewPath = realpath($viewPath);

        if (!$viewPath || !file_exists($viewPath)) {
            die("❌ View file not found: " . $viewPath);
        }

        extract($data, EXTR_SKIP);
        require $viewPath;
    }
}

<?php
namespace App\Core;

class Controller
{
    /**
     * Load a model dynamically
     */
    protected function model(string $model)
    {
        $class = "App\\Models\\" . ucfirst($model);
        if (!class_exists($class)) {
            throw new \Exception("Model not found: " . $class);
        }
        return new $class();
    }

    /**
     * Render a view using the global helper
     */
    protected function view(string $view, array $data = []): void
    {
        view_render($view, $data); 
    }

    /**
     * Send JSON response using the global helper
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        json_response($data, $statusCode); 
    }
}

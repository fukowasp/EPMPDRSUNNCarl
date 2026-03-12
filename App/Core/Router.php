<?php
namespace App\Core;

class Router
{
    protected $routes = [];

    public function get($uri, $action): void
    {
        $uri = strtolower(trim($uri, '/'));
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action): void
    {
        $uri = strtolower(trim($uri, '/'));
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($uri): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Normalize incoming request
        $uri = strtolower(trim($uri, '/'));

        $routes = $this->routes[$method] ?? [];

        if (!isset($routes[$uri])) {

            if ($method === 'POST') {
                json_response([
                    'success' => false,
                    'message' => 'Route not found'
                ], 404);
            }

            show_error(404);
            return;
        }

        $action = $routes[$uri];

        if (is_string($action)) {
            $parts = explode('@', $action);
            $controller = 'App\\Controllers\\' . str_replace('/', '\\', $parts[0]);
            $method = $parts[1] ?? 'index';

            if (!class_exists($controller)) {
                show_error(500);
                return;
            }

            $controllerInstance = new $controller();

            if (!method_exists($controllerInstance, $method)) {
                show_error(500);
                return;
            }

            $controllerInstance->$method();
            return;
        }

        if (is_array($action) && count($action) === 2) {
            $controller = new $action[0]();
            $method = $action[1];

            if (!method_exists($controller, $method)) {
                show_error(500);
                return;
            }

            $controller->$method();
            return;
        }

        show_error(500);
    }
}


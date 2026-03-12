<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../App/bootstrap.php';
require_once __DIR__ . '/../App/Core/autoload.php';

use App\Core\Router;

// Init router
$router = new Router();

// Load routes
require_once __DIR__ . '/../App/routes/web.php';

// Dispatch request
$uri = $_GET['url'] ?? '/';
$router->dispatch($uri);

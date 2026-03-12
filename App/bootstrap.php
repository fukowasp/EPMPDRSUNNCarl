<?php
// Enable errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include files with exact folder case
require_once __DIR__ . '/Core/autoload.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/Helpers/autoload.php';

$router = new \App\Core\Router();

<?php
/**
 * config/config.php
 * Securely load environment variables, define constants, and provide a helper function.
 * Will NOT run if .env is missing or required env variables are empty.
 */

$dotenvPath = __DIR__ . '/../../.env'; // Path to project root

// Stop execution if .env is missing
if (!file_exists($dotenvPath)) {
    throw new RuntimeException(
        "❌ Configuration error: .env file is missing. Please restore it to run " . basename(__DIR__)
    );
}

// Parse .env file
$config = [];
foreach (file($dotenvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);

    if ($line === '' || str_starts_with($line, '#') || strpos($line, '=') === false) {
        continue;
    }

    [$name, $value] = explode('=', $line, 2);
    $name  = trim($name);
    $value = trim($value, "\"'");

    $config[$name] = $value;

    // Inject into environment so getenv() works
    putenv("$name=$value");
    $_ENV[$name] = $value;
    $_SERVER[$name] = $value;
}

// Required environment variables
$required = ['APP_NAME', 'APP_URL', 'DB_HOST', 'DB_NAME', 'DB_USER'];
foreach ($required as $key) {
    if (empty($config[$key])) {
        throw new RuntimeException(
            "❌ Configuration error: Required env variable '$key' is missing or empty."
        );
    }
}

// Define constants
define('APP_NAME', $config['APP_NAME']);
define('URLROOT', $config['APP_URL']);
define('DB_HOST', $config['DB_HOST']);
define('DB_NAME', $config['DB_NAME']);
define('DB_USER', $config['DB_USER']);
define('DB_PASS', $config['DB_PASS'] ?? '');
define('MAINTENANCE_MODE', $config['MAINTENANCE_MODE'] ?? 'off');

// Helper function to fetch config values
if (!function_exists('config')) {
    function config(string $key, $default = null) {
        static $cache = null;

        if ($cache === null) {
            $cache = [
                'app_name' => APP_NAME,
                'url_root' => URLROOT,
                'db' => [
                    'host' => DB_HOST,
                    'name' => DB_NAME,
                    'user' => DB_USER,
                    'pass' => DB_PASS,
                ],
                'maintenance_mode' => MAINTENANCE_MODE
            ];
        }

        $keys = explode('.', $key);
        $value = $cache;

        foreach ($keys as $k) {
            if (is_array($value) && array_key_exists($k, $value)) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }

        return $value;
    }
}

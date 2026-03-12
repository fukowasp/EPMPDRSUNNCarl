<?php

if (!function_exists('show_error')) {
    function show_error($code)
    {
        // Set proper HTTP status code
        http_response_code($code);

        // Path to error views (make sure the folder is named "views", not "Views")
        $errorFile   = __DIR__ . '/../views/error/' . $code . '.php';
        $defaultFile = __DIR__ . '/../views/error/default.php';

        // If specific error page exists (404.php, 500.php, etc.)
        if (file_exists($errorFile)) {
            require $errorFile;

        // Otherwise, load default error page
        } elseif (file_exists($defaultFile)) {
            require $defaultFile;

        // Fallback if nothing exists
        } else {
            echo "<h1>{$code} Error</h1>";
        }

        exit; // Stop further execution
    }
}

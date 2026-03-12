<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string {
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }
}

if (!function_exists('csrf_input')) {
    function csrf_input(): string {
        return '<input type="hidden" name="_csrf_token" value="' .
               htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
    }
}

if (!function_exists('csrf_verify')) {
    function csrf_verify(?string $token = null): bool {
        $sessionToken = $_SESSION['_csrf_token'] ?? null;
        
        if ($token === null) {
            // Check multiple sources for token
            $token = $_POST['_csrf_token'] ?? null;
            
            if (!$token) {
                // Check HTTP_X_CSRF_TOKEN header (standard)
                $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            }
            
            if (!$token) {
                // Check with HTTP_ prefix (some servers format it differently)
                $headers = getallheaders();
                $token = $headers['X-Csrf-Token'] ?? $headers['X-CSRF-TOKEN'] ?? null;
            }
            
            if (!$token) {
                $token = $_GET['_csrf_token'] ?? '';
            }
        }

        if (!$sessionToken || !$token) {
            return false;
        }

        return hash_equals($sessionToken, $token);
    }
}

if (!function_exists('csrf_json')) {
    function csrf_json(): array {
        return ['csrf_token' => csrf_token()];
    }
}

if (!function_exists('csrf_meta')) {
    function csrf_meta(): string {
        return '<meta name="csrf-token" content="' . 
               htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
    }
}

if (!function_exists('csrf_check_or_fail')) {
    function csrf_check_or_fail(): void {
        $token = $_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!hash_equals($_SESSION['_csrf_token'] ?? '', $token)) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'Invalid CSRF token',
                'csrf_token' => bin2hex(random_bytes(32)) // regenerate
            ]);
            exit;
        }
    }
}


if (!function_exists('csrf_regenerate')) {
    function csrf_regenerate(): string {
        unset($_SESSION['_csrf_token']);
        return csrf_token();
    }
}
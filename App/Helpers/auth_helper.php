<?php
namespace App\Helpers;

use App\Models\Employee\Dashboard\Dashboard;
use App\Models\Employee\Info\Info;

class Auth {

    // ---------------- Employee Methods ----------------
    public static function user() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['employee']['employee_id'])) return null;

        $sessionUser = $_SESSION['employee'];
        $employeeId  = $sessionUser['employee_id'];

        $dbInfo = [];

        // Try to get data from Dashboard model first
        $model = new Dashboard();
        $dashboardInfo = $model->getPersonalInfo($employeeId);

        if ($dashboardInfo && is_array($dashboardInfo) && !empty($dashboardInfo)) {
            $dbInfo = $dashboardInfo;
        } else {
            // Try Info model as second fallback
            $infoModel = new Info();
            $infoData = $infoModel->getByEmployeeId($employeeId);
            
            if ($infoData && is_array($infoData) && !empty($infoData)) {
                $dbInfo = $infoData;
            } else {
                // Final fallback: get from employee_register table
                try {
                    $pdo = \App\Core\Database::getInstance();
                    $stmt = $pdo->prepare("SELECT employee_id, department, employment_type FROM employee_register WHERE employee_id = :id LIMIT 1");
                    $stmt->execute([':id' => $employeeId]);
                    $registerData = $stmt->fetch(\PDO::FETCH_ASSOC);
                    
                    if ($registerData && is_array($registerData)) {
                        $dbInfo = $registerData;
                    }
                } catch (\PDOException $e) {
                    error_log('Auth::user() fallback error: ' . $e->getMessage());
                }
            }
        }

        return array_merge($sessionUser, $dbInfo);
    }

    public static function id() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return $_SESSION['employee']['employee_id'] ?? null;
    }

    public static function check(): bool {
        return self::user() !== null;
    }

    public static function login(array $employee): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        
        // Store only employee_id in session, let Auth::user() fetch the rest from DB
        $_SESSION['employee'] = [
            'employee_id' => $employee['employee_id'] ?? null
        ];
        
        session_regenerate_id(true);
    }

    public static function logout(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
        session_start();
        session_regenerate_id(true);
        header("Location: " . base_url('employee/login'));
        exit;
    }

    // ---------------- Admin Methods ----------------
    public static function adminUser() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return $_SESSION['admin'] ?? null;
    }

    public static function adminId() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return $_SESSION['admin_id'] ?? null;
    }

    public static function adminCheck(): bool {
        return self::adminUser() !== null;
    }

    public static function adminLogin(array $admin): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['admin_id'] = $admin['id'] ?? null;
        $_SESSION['admin']    = $admin;
        session_regenerate_id(true);
    }

    public static function adminLogout(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        unset($_SESSION['admin'], $_SESSION['admin_id']);
        session_destroy();
        session_start();
        session_regenerate_id(true);
        header("Location: " . base_url('admin/login'));
        exit;
    }

    // ---------------- Full Admin Methods ----------------
    public static function fullAdminUser() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return $_SESSION['fulladmin'] ?? null;
    }

    public static function fullAdminId() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return $_SESSION['fulladmin_id'] ?? null;
    }

    public static function fullAdminCheck(): bool {
        return self::fullAdminUser() !== null;
    }

    public static function fullAdminLogin(array $fullAdmin): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['fulladmin_id'] = $fullAdmin['id'] ?? null;
        $_SESSION['fulladmin']    = $fullAdmin;
        session_regenerate_id(true);
    }

    public static function fullAdminLogout(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        unset($_SESSION['fulladmin'], $_SESSION['fulladmin_id']);
        session_destroy();
        session_start();
        session_regenerate_id(true);
        header("Location: " . base_url('admin/login'));
        exit;
    }

    // ---------------- PDC Methods ----------------
    public static function pdcUser() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return $_SESSION['pdc'] ?? null;
    }

    public static function pdcId() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return $_SESSION['pdc_id'] ?? null;
    }

    public static function pdcCheck(): bool {
        return self::pdcUser() !== null;
    }

    public static function pdcLogin(array $pdc): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['pdc_id'] = $pdc['id'] ?? null;
        $_SESSION['pdc']    = $pdc;
        session_regenerate_id(true);
    }

    public static function pdcLogout(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        unset($_SESSION['pdc'], $_SESSION['pdc_id']);
        session_destroy();
        session_start();
        session_regenerate_id(true);
        header("Location: " . base_url('pdc/login'));
        exit;
    }
}
<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Admin\AdminLogin;

class AdminLoginController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new AdminLogin();
    }

    public function index()
    {
        if (Auth::adminCheck()) {
            header("Location: " . base_url('admin/dashboard'));
            exit;
        }
        if (Auth::fullAdminCheck()) {
            header("Location: " . base_url('admin/fulladmindashboard'));
            exit;
        }

        return $this->view('Admin/AdminLogin');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(['success' => false, 'message' => 'Invalid request', 'csrf_token' => csrf_token()], 405);
        }

        // ✅ Verify CSRF token before processing
        if (!csrf_verify($_POST['_csrf_token'] ?? null)) {
            return $this->json(['success' => false, 'message' => 'Invalid CSRF token', 'csrf_token' => csrf_token()], 403);
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->model->getByUsernameAndRoles($username, ['admin','fulladmin']);

        if ($user && password_verify($password, $user['password'])) {

            if ($user['status'] === 'inactive') {
                return $this->json([
                    'success' => false,
                    'message' => 'Your account is inactive. Please contact the superadmin.',
                    'csrf_token' => csrf_token()
                ]);
            }

            if ($user['role'] === 'admin') {
                Auth::adminLogin($user);
                $redirect = base_url('admin/dashboard');
            } elseif ($user['role'] === 'fulladmin') {
                Auth::fullAdminLogin($user);
                $redirect = base_url('admin/fulladmindashboard');
            }

            // ✅ Return fresh CSRF token with JSON
            return $this->json([
                'success' => true,
                'message' => 'Logged in successfully',
                'redirect' => $redirect,
                'csrf_token' => csrf_regenerate()
            ]);
        }

        // Always return fresh CSRF token even on failure
        return $this->json([
            'success' => false,
            'message' => 'Invalid credentials',
            'csrf_token' => csrf_token()
        ]);
    }

    public function logout()
    {
        if (Auth::fullAdminCheck()) {
            Auth::fullAdminLogout();
        } else {
            Auth::adminLogout();
        }

        // Optional: return JSON with fresh CSRF for next login
        return $this->json(['success' => true, 'csrf_token' => csrf_regenerate()]);
    }
}

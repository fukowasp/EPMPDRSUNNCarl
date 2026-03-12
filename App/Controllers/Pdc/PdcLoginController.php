<?php
namespace App\Controllers\Pdc;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Pdc\PdcLogin;

class PdcLoginController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new PdcLogin();
    }

    // Show login page
    public function index()
    {
        if (Auth::pdcCheck()) {
            header("Location: " . base_url('pdc/dashboard'));
            exit;
        }

        return $this->view('Pdc/PdcLogin');
    }

    // Handle login POST
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(['success' => false, 'message' => 'Invalid request.']);
        }

        csrf_check_or_fail();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Input validation
        if (strlen($username) < 3 || strlen($password) < 6) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid login credentials.'
            ]);
        }

        $user = $this->model->getByUsername($username);

        $fakeHash = '$2y$10$abcdefghijklmnopqrstuv';
        $validPassword = false;

        if ($user && isset($user['password'])) {
            $validPassword = password_verify($password, $user['password']);
        } else {
            password_verify($password, $fakeHash); // timing attack protection
        }

        if ($user && strtolower($user['role']) === 'pdc' && $validPassword) {
            session_regenerate_id(true);
            Auth::pdcLogin($user);

            return $this->json([
                'success' => true,
                'redirect' => base_url('pdc/dashboard')
            ]);
        }

        // Generic message — always 200 for AJAX
        return $this->json([
            'success' => false,
            'message' => 'Invalid login credentials.'
        ]);
    }

    // Logout
    public function logout()
    {
        // CSRF check for POST logout
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            csrf_check_or_fail();
            Auth::pdcLogout();
        } else {
            json_response(['success' => false, 'message' => 'Invalid request'], 405);
        }
    }
}
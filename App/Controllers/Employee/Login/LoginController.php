<?php
namespace App\Controllers\Employee\Login;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Employee\Login\Login;

class LoginController extends Controller
{
    protected Login $loginModel;

    public function __construct()
    {
        $this->loginModel = new Login();
    }

    // Render login page
    public function index()
    {
        if (Auth::check()) {
            header('Location: ' . base_url('employee/dashboard'));
            exit;
        }

        view_render('Employee/Login/Login'); 
    }

    // Handle login POST (JSON response)
    public function login()
    {
        header('Content-Type: application/json');

        $employee_id = $_POST['employee_id'] ?? '';
        $password    = $_POST['password'] ?? '';

        if (!$employee_id || !$password) {
            echo json_encode(['status'=>'error','message'=>'Employee ID and password are required']);
            return;
        }

        $result = $this->loginModel->checkCredentials($employee_id, $password);

        if ($result['status'] === 'success') {
            Auth::login($result['employee']); // store session
            echo json_encode([
                'status'=>'success',
                'message'=>'Login successful',
                'redirect'=>base_url('employee/dashboard')
            ]);
        } else {
            echo json_encode([
                'status'=>'error',
                'message'=>$result['message'],
                'type'=>$result['type'] ?? null
            ]);
        }
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        echo json_encode(['status'=>'success','message'=>'Logged out']);
    }
}

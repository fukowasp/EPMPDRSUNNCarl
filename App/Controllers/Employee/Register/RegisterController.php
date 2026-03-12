<?php
namespace App\Controllers\Employee\Register;

use App\Core\Controller;
use App\Models\Employee\Register\Register as RegisterModel;

class RegisterController extends Controller
{
    protected RegisterModel $registerModel;

    public function __construct()
    {
        $this->registerModel = new RegisterModel();
    }

    public function index(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        view_render('Employee/Register/Register');
    }

    public function register(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $data = json_decode(file_get_contents('php://input'), true);

        $employee_id     = trim($data['employee_id'] ?? '');
        $department      = trim($data['department'] ?? '');
        $employment_type = trim($data['employment_type'] ?? '');
        $password        = trim($data['password'] ?? '');

        $errors = [];

        // Simple validation
        if (!$employee_id) $errors['employee_id'] = 'Employee ID is required';
        if (!$department) $errors['department'] = 'Department is required';
        if (!$employment_type) $errors['employment_type'] = 'Employment Type is required';
        if (!$password) $errors['password'] = 'Password is required';

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['status'=>'error','errors'=>$errors]);
            return;
        }

        if ($this->registerModel->existsEmployee($employee_id)) {
            http_response_code(409);
            echo json_encode(['status'=>'error','message'=>'Employee ID already exists']);
            return;
        }

        // Save to employee_register table only
        $result = $this->registerModel->saveEmployee([
            'employee_id'     => $employee_id,
            'department'      => $department,
            'employment_type' => $employment_type,
            'password'        => $password 
        ]);

        if ($result === true) {
            echo json_encode([
                'status'=>'success',
                'message'=>'Registration successful! Please login.',
                'redirect'=> base_url('employee/login')
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['status'=>'error','message'=>'Server error: ' . $result]);
        }
    }
}

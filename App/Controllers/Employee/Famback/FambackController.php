<?php
namespace App\Controllers\Employee\Famback;

use App\Core\EmployeeBaseController; // <-- Extend the base controller
use App\Helpers\Auth;
use App\Models\Employee\Famback\Famback;

class FambackController extends EmployeeBaseController
{
    protected Famback $fambackModel;

    public function __construct()
    {
        parent::__construct(); // <-- Load global employee data for sidebar

        $this->fambackModel = new Famback();
    }

    // Render Family Background page
    public function index()
    {
        if (!Auth::check()) {
            header("Location: " . base_url('employee/login'));
            exit;
        }

        // Use $this->view() so sidebar automatically gets global employee data
        $this->view('Employee/Famback/Famback');
    }

    // Get family background JSON
    public function get()
    {
        header('Content-Type: application/json');
        $employee = Auth::user();
        if (!$employee || empty($employee['employee_id'])) {
            echo json_encode(["success" => false, "error" => "Unauthorized"]);
            exit;
        }

        $data = $this->fambackModel->getByEmployeeId($employee['employee_id']);
        echo json_encode(["success" => true, "data" => $data]);
        exit;
    }

    // Save family background JSON (upsert)
    public function save()
    {
        header('Content-Type: application/json');
        $employee = Auth::user();
        if (!$employee || empty($employee['employee_id'])) {
            echo json_encode(["success" => false, "error" => "Unauthorized"]);
            exit;
        }

        $input = json_decode(file_get_contents("php://input"), true);
        if (!$input || !is_array($input)) {
            echo json_encode(["success" => false, "error" => "Invalid input"]);
            exit;
        }

        $input['employee_id'] = $employee['employee_id'];

        // Clean children array
        if (!empty($input['children']) && is_array($input['children'])) {
            $cleanChildren = [];
            foreach ($input['children'] as $c) {
                if (!empty($c['child_name']) && !empty($c['child_birthdate'])) {
                    $cleanChildren[] = [
                        "child_name" => htmlspecialchars(trim($c['child_name']), ENT_QUOTES, 'UTF-8'),
                        "child_birthdate" => $c['child_birthdate']
                    ];
                }
            }
            $input['children'] = $cleanChildren;
        }

        $success = $this->fambackModel->save($input);

        if ($success) {
            echo json_encode([
                "success" => true,
                "message" => "Family background saved successfully.",
                "redirect" => base_url('employee/dashboard')
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "error" => "Failed to save family background."
            ]);
        }
        exit;
    }
}

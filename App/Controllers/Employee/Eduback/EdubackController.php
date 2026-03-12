<?php
namespace App\Controllers\Employee\Eduback;

use App\Core\EmployeeBaseController; // <-- Extend base controller
use App\Helpers\Auth;
use App\Models\Employee\Eduback\Eduback;

class EdubackController extends EmployeeBaseController
{
    protected Eduback $model;
    protected ?string $employeeId;

    public function __construct()
    {
        parent::__construct(); // <-- Load sidebar globals

        $this->model = new Eduback();
        $this->employeeId = Auth::id();

        if (!$this->employeeId) {
            header('Location: ' . base_url('employee/login'));
            exit;
        }
    }

    /** View */
    public function index(): void
    {
        // Use $this->view() to include global employee data in sidebar
        $this->view('Employee/Eduback/Eduback');
    }

    /** Get educational background only */
    public function get(): void
    {
        try {
            $data = $this->model->getByEmployee($this->employeeId);
            // Only send educational background
            json_response([
                'success' => true,
                'message' => 'Data fetched',
                'data' => $data['educational_background'] ?? []
            ]);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            json_response([
                'success' => false,
                'message' => 'Failed to load education data',
                'data' => []
            ]);
        }
    }

    /** Save educational background only */
    public function save(): void
    {
        $educ = $_POST['educational_background'] ?? [];

        $success = $this->model->save($this->employeeId, $educ, []); // grads empty
        json_response([
            'success' => $success,
            'message' => $success ? 'Saved successfully' : 'Failed to save',
            'data' => []
        ]);
    }
}

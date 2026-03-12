<?php
namespace App\Controllers\Employee\Workexp;

use App\Core\EmployeeBaseController; // <-- extend base controller
use App\Helpers\Auth;
use App\Models\Employee\Workexp\Workexp;

class WorkexpController extends EmployeeBaseController
{
    protected Workexp $model;
    protected ?string $employeeId;

    public function __construct()
    {
        parent::__construct(); // <-- loads sidebar globals

        $this->model = new Workexp();
        $this->employeeId = Auth::id();

        // Ensure employee is logged in
        if (!$this->employeeId) {
            header('Location: ' . base_url('employee/login'));
            exit;
        }
    }

    // Show the work experience form
    public function index(): void
    {
        $this->view('Employee/Workexp/Workexp');
    }

    // Fetch all work experiences
    public function get(): void
    {
        $data = $this->model->all($this->employeeId);
        json_response(['success' => true, 'data' => $data]);
    }

    // Save work experience (create or update)
    public function save(): void
    {
        $id = $_POST['id'] ?? null;

        $data = [
            'work_date_from'    => $_POST['date_from'] ?? null,
            'work_date_to'      => $_POST['date_to'] ?? null,
            'work_position'     => $_POST['position'] ?? '',
            'work_company'      => $_POST['company'] ?? '',
            'work_salary'       => $_POST['salary'] ?? null,
            'work_grade'        => $_POST['grade'] ?? '',
            'work_status'       => $_POST['status'] ?? '',
            'work_govt_service' => $_POST['govt_service'] ?? '',
        ];

        if (!empty($id)) {
            if ($this->model->update((int)$id, $this->employeeId, $data)) {
                json_response(['success' => true, 'message' => 'Record updated successfully']);
            } else {
                json_response(['success' => false, 'message' => 'Update failed'], 400);
            }
        } else {
            $data['employee_id'] = $this->employeeId;
            if ($this->model->create($data)) {
                json_response(['success' => true, 'message' => 'Record saved successfully']);
            } else {
                json_response(['success' => false, 'message' => 'Save failed'], 400);
            }
        }
    }

    // Delete work experience
    public function delete(): void
    {
        $id = $_POST['id'] ?? 0;
        if ($this->model->delete((int)$id, $this->employeeId)) {
            json_response(['success' => true, 'message' => 'Record deleted successfully']);
        } else {
            json_response(['success' => false, 'message' => 'Delete failed'], 400);
        }
    }
}

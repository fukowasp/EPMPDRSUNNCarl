<?php
namespace App\Controllers\Employee\Trainings;

use App\Core\EmployeeBaseController;
use App\Models\Employee\Trainings\Trainings;

class TrainingsController extends EmployeeBaseController
{
    private Trainings $model;

    public function __construct()
    {
        parent::__construct(); // Load global employee data
        $this->model = new Trainings();
    }

    // Load Training History Page
    public function index(): void
    {
        $this->view('Employee/Trainings/Trainings');
    }

    // Fetch trainings for the logged-in employee (GET)
    public function fetchTrainings(): void
    {
        $employee_id = $this->globalEmployeeData['personalInfo']['employee_id'] ?? null;
        if (!$employee_id) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 401);
            return;
        }

        $trainings = $this->model->getTrainingsByEmployee($employee_id);
        $this->json(['success' => true, 'data' => $trainings]);
    }

    // Accept training (POST + CSRF)
    public function acceptTraining(): void
    {
        $this->handleTrainingAction('Accepted');
    }

    // Cancel/Decline training (POST + CSRF)
    public function cancelTraining(): void
    {
        $this->handleTrainingAction('Cancelled');
    }

    private function handleTrainingAction(string $status): void
    {
        // CSRF check
        if (!csrf_verify()) {
            $this->json(['success' => false, 'message' => 'Invalid CSRF token']);
            return;
        }

        $employee_id = $this->globalEmployeeData['personalInfo']['employee_id'] ?? null;
        $employee_training_id = $_POST['id'] ?? null;
        $reason = $_POST['reason'] ?? null;

        if (!$employee_training_id || !$employee_id) {
            $this->json(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        if ($status === 'Cancelled' && empty(trim($reason))) {
            $this->json(['success' => false, 'message' => 'Cancellation reason is required']);
            return;
        }

        $success = $this->model->updateTrainingStatus(
            (int)$employee_training_id,
            $employee_id,
            $status,
            $reason
        );

        $this->json(['success' => $success]);
    }
}

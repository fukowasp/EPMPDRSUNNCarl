<?php
namespace App\Controllers\Employee\Dashboard;

use App\Core\EmployeeBaseController; // Changed from Controller
use App\Models\Employee\Dashboard\Dashboard;

class DashboardController extends EmployeeBaseController // Changed here
{
    protected $dashboardModel;

    public function __construct()
    {
        parent::__construct(); // IMPORTANT: Call parent constructor first
        
        $this->dashboardModel = new Dashboard();
    }

    public function index()
    {
        if (!isset($_SESSION['employee']['employee_id'])) {
            header("Location: " . base_url("employee/login"));
            exit;
        }

        $employeeId = $_SESSION['employee']['employee_id'];

        // Trainings
        $pendingInvites = $this->dashboardModel->getPendingTrainingInvites($employeeId);
        $acceptedTrainingsCount = $this->dashboardModel->getAcceptedTrainingsCount($employeeId);
        $ldTotals = $this->dashboardModel->getTotalLearningDevelopmentHours($employeeId);

        $data = [
            'pendingInvites'          => $pendingInvites,
            'acceptedTrainingsCount'  => $acceptedTrainingsCount,
            'totalTrainingsCompleted' => $ldTotals['totalTrainings'],
            'totalTrainingHours'      => $ldTotals['totalHours']
        ];

        // Use $this->view() instead of view_render()
        // This will automatically merge sidebar data (employeeName, personalInfo)
        $this->view('Employee/Dashboard/Dashboard', $data);
    }
}
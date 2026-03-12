<?php
namespace App\Controllers\Pdc;

use App\Core\Controller;
use App\Models\Pdc\TrainingParticipants;
use App\Helpers\Auth;

class TrainingParticipantsController extends Controller
{
    private TrainingParticipants $model;

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start(); // ensure session active

        $this->model = new TrainingParticipants();

        // Require PDC login for all controller actions
        if (!Auth::pdcCheck()) {
            // JSON if AJAX, otherwise redirect
            if ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' === 'XMLHttpRequest') {
                json_response(['success' => false, 'message' => 'Unauthorized']);
            } else {
                header("Location: " . base_url('pdc/login'));
            }
            exit;
        }
    }

    /** Show main view */
    public function index(): void
    {
        $this->view('Pdc/TrainingParticipants', ['csrf_token' => csrf_token()]);
    }

    /** Fetch all participants */
    public function getParticipants(): void
    {
        // Make sure user is PDC
        if (!Auth::pdcCheck()) {
            // If AJAX, return JSON; otherwise redirect
            if ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' === 'XMLHttpRequest') {
                json_response(['success' => false, 'message' => 'Unauthorized']);
            } else {
                header("Location: " . base_url('pdc/login'));
            }
            exit;
        }

        // Fetch participants
        $participants = $this->model->getAllParticipants();
        json_response(['success' => true, 'data' => $participants]);
    }


    /** Add a participant */
    public function addParticipant(): void
    {
        if (!csrf_verify()) {
            json_response(['success' => false, 'message' => 'Invalid CSRF token']);
        }

        $success = $this->model->addParticipant($_POST);
        json_response(['success' => $success]);
    }

   /** Delete a participant */
    public function deleteParticipant()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return json_response(['success' => false, 'message' => 'Invalid request method']);
        }

        $csrf_token = $_POST['_csrf_token'] ?? '';
        if (!csrf_verify($csrf_token)) {
            return json_response(['success' => false, 'message' => 'Invalid CSRF token']);
        }

        $employee_id = $_POST['employee_id'] ?? null;
        $training_id = $_POST['training_id'] ?? null;

        if (!$employee_id || !$training_id) {
            return json_response(['success' => false, 'message' => 'Missing participant or training ID']);
        }

        $deleted = $this->model->deleteById($employee_id, (int)$training_id);

        return json_response([
            'success' => $deleted,
            'message' => $deleted ? 'Participant deleted successfully' : 'Failed to delete participant'
        ]);
    }



    /** Content-Based Employee Recommendation */
    public function getRecommendedEmployeesContentBased(): void
    {
        // Use GET now
        $training_id = $_GET['training_id'] ?? null;
        if (!$training_id) {
            json_response(['success' => false, 'data' => [], 'message' => 'No training selected']);
        }

        $employees = $this->model->recommendEmployeesContentBased((int)$training_id);
        json_response([
            'success' => !empty($employees),
            'data' => $employees,
            'message' => empty($employees) ? 'No matching employees found' : ''
        ]);
    }

}

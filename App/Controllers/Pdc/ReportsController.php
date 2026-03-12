<?php
namespace App\Controllers\Pdc;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Pdc\Reports;

class ReportsController extends Controller
{
    private Reports $model;

    public function __construct()
    {
        // ✅ Only allow PDC users
        if (!Auth::pdcCheck()) {
            header("Location: " . base_url('pdc/login'));
            exit;
        }

        $this->model = new Reports();
    }

    /** Main reports page */
    public function index()
    {
        $pdcUser = Auth::pdcUser(); // optional: pass user info to view
        $this->view('Pdc/reports', [
            'user' => $pdcUser
        ]);
    }

    /** JSON: Participants Table */
    public function getParticipantsReport()
    {
        json_response([
            'success' => true,
            'data'    => $this->model->getAllParticipants()
        ]);
    }

    /** JSON: Participants Bar Chart */
    public function getParticipantsChart()
    {
        json_response([
            'success' => true,
            'data'    => $this->model->getParticipantsByTraining()
        ]);
    }

    /** JSON: Participants Status Pie Chart */
    public function getParticipantsStatusChart()
    {
        json_response([
            'success' => true,
            'data'    => $this->model->getParticipantsStatusCounts()
        ]);
    }
}
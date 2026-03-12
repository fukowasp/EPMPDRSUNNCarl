<?php
namespace App\Controllers\Pdc;

use App\Core\Controller;
use App\Models\Pdc\PdcDashboard;
use App\Helpers\Auth; 

class PdcDashboardController extends Controller
{
    private PdcDashboard $dashboard;

    public function __construct()
    {
        if (!Auth::pdcCheck()) {
            header("Location: " . base_url('pdc/login'));
            exit;
        }

        $this->dashboard = new PdcDashboard();
    }

    /** Load dashboard view */
    public function index()
    {
        $pdcUser = Auth::pdcUser(); 
        $this->view('Pdc/PdcDashboard', [
            'user' => $pdcUser
        ]);
    }

    /** AJAX: fetch dashboard stats */
    public function stats()
    {
        json_response($this->dashboard->getDashboardData());
    }
}
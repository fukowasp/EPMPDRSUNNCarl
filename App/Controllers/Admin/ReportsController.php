<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Admin\Report;

class ReportsController extends Controller
{
    protected Report $report;

    public function __construct()
    {
        // ---------------- Admin Auth Check ----------------
        if (!Auth::adminCheck()) {
            header("Location: " . base_url('admin/login'));
            exit;
        }

        $this->report = new Report();
    }

    /** Show table + chart */
    public function index(): void
    {
        $graduates = $this->report->getGraduateStudies();
        view_render('Admin/Reports', ['graduates' => $graduates]);
    }

    /** JSON endpoint for Chart.js via POST */
    public function chartData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            json_response(['error' => 'Method Not Allowed']);
            return;
        }

        $data = $this->report->getGraduateStudiesChartData();
        json_response($data);
    }
}

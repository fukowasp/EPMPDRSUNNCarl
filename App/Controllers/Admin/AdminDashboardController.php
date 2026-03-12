<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Admin\AdminDashboard;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!Auth::adminCheck()) {
            header("Location: " . base_url('admin/login'));
            exit;
        }

        $admin = Auth::adminUser();
        return $this->view('Admin/AdminDashboard', ['admin' => $admin]);
    }

    /**
     * Fetch dashboard data (GET request - no CSRF needed)
     */
    public function fetch()
    {
        if (!Auth::adminCheck()) {
            return json_response(['error' => 'Unauthorized'], 403);
        }

        $model = new AdminDashboard();

        $data = [
            'totalEmployees' => $model->getTotalEmployees(),
            'totalPermanentEmployees' => $model->getTotalPermanentEmployees(),
            'totalNonPermanentEmployees' => $model->getTotalNonPermanentEmployees(),
            'graduateStudies' => $model->getGraduateStudyDistribution()
        ];

        return json_response([
            'success' => true,
            'data' => $data,
            'csrf_token' => csrf_token()
        ]);
    }
}
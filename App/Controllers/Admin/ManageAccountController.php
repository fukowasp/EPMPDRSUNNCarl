<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Admin\ManageAccount;

class ManageAccountController extends Controller
{
    protected ManageAccount $model;

    public function __construct()
    {
        $this->model = new ManageAccount();

        if (!Auth::adminCheck()) {
            if ($this->isAjax()) {
                json_response(['success' => false, 'message' => 'Unauthorized'], 401);
            }
            header("Location: " . base_url('admin/login'));
            exit;
        }
    }

    private function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function index()
    {
        // Loads the view (modal, datatable) with CSRF token
        $this->view('Admin/ManageAccount', ['csrf_token' => csrf_token()]);
    }

    public function fetchAllJson()
    {
        $this->model->getAll();
    }

    public function add()
    {
        csrf_check_or_fail();
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            json_response(['success' => false, 'message' => 'Invalid JSON input'], 400);
        }

        $this->model->save($input); // model decides add vs update based on ID
    }

    public function update()
    {
        csrf_check_or_fail();
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            json_response(['success' => false, 'message' => 'Invalid JSON input'], 400);
        }

        $this->model->save($input); // model decides add vs update based on ID
    }

    public function delete()
    {
        csrf_check_or_fail();
        $input = json_decode(file_get_contents('php://input'), true);

        $id = (int)($input['id'] ?? 0);
        if (!$id) {
            json_response(['success' => false, 'message' => 'Invalid ID'], 400);
        }

        $this->model->delete($id);
    }

    public function getAllDepartments()
    {
        csrf_check_or_fail(); // optional, keep CSRF for AJAX POST requests
        $this->model->getAllDepartments();
    }

    public function getAllAcademicRanks()
    {
        csrf_check_or_fail();
        $this->model->getAllAcademicRanks();
    }
}

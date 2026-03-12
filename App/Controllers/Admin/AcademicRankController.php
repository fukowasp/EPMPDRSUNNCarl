<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Admin\AcademicRank;

class AcademicRankController extends Controller
{
    protected AcademicRank $model;

    public function __construct()
    {
        $this->model = new AcademicRank();

        // Check admin session
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

    private function validateInput(): ?string
    {
        $name = trim($_POST['rank_name'] ?? '');
        if ($name === '' || strlen($name) > 150) {
            return 'Invalid rank name';
        }
        return null;
    }

    private function getId(): int
    {
        return (int)($_POST['id'] ?? 0);
    }

    public function index()
    {
        // CSRF token for the forms (via helper)
        $this->view('Admin/AcademicRank', ['csrf_token' => csrf_token()]);
    }

    public function getAll()
    {
        $this->model->getAll(); // Already returns JSON
    }

    public function add()
    {
        csrf_check_or_fail(); // <-- Use global helper

        $error = $this->validateInput();
        if ($error) {
            json_response(['success' => false, 'message' => $error], 400);
        }

        $name = trim($_POST['rank_name']);
        $this->model->add($name);
    }

    public function update()
    {
        csrf_check_or_fail(); // <-- Use global helper

        $id = $this->getId();
        $error = $this->validateInput();
        if ($error) {
            json_response(['success' => false, 'message' => $error], 400);
        }

        $name = trim($_POST['rank_name']);
        $this->model->update($id, $name);
    }

    public function delete()
    {
        csrf_check_or_fail(); // <-- Use global helper

        $id = $this->getId();
        $this->model->delete($id);
    }
}

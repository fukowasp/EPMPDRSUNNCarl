<?php
namespace App\Controllers\Pdc;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Pdc\TrainingTypes;

class TrainingTypesController extends Controller
{
    private TrainingTypes $model;

    public function __construct()
    {
        // ✅ Ensure PDC is logged in
        if (!Auth::pdcCheck()) {
            header('Location: ' . base_url('pdc/login'));
            exit;
        }

        $this->model = new TrainingTypes();
    }

    /** 🧭 Main view */
    public function index(): void
    {
        $this->view('Pdc/TrainingTypes');
    }

    /** 📦 Fetch all training types (AJAX) */
    public function fetch(): void
    {
        $data = $this->model->getAll();
        json_response(['data' => $data]);
        exit;
    }

    /** ➕ Store new record */
    public function store(): void
    {
        if (!csrf_verify()) {
            json_response(['status' => 'error', 'message' => 'Invalid CSRF token']);
            exit;
        }

        $name = trim($_POST['type_name'] ?? '');
        if ($name === '') {
            json_response(['status' => 'error', 'message' => 'Type name is required']);
            exit;
        }

        $ok = $this->model->store($name);
        json_response([
            'status' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Added successfully' : 'Failed to add'
        ]);
        exit;
    }

    /** ✏️ Update existing record */
    public function update(): void
    {
        if (!csrf_verify()) {
            json_response(['status' => 'error', 'message' => 'Invalid CSRF token']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['type_name'] ?? '');

        if ($id <= 0 || $name === '') {
            json_response(['status' => 'error', 'message' => 'Invalid data']);
            exit;
        }

        $ok = $this->model->updateType($id, $name);
        json_response([
            'status' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Updated successfully' : 'Failed to update'
        ]);
        exit;
    }

    /** 🗑️ Delete record */
    public function delete(): void
    {
        if (!csrf_verify()) {
            json_response(['status' => 'error', 'message' => 'Invalid CSRF token']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            json_response(['status' => 'error', 'message' => 'Invalid ID']);
            exit;
        }

        $ok = $this->model->deleteType($id);
        json_response([
            'status' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Deleted successfully' : 'Failed to delete'
        ]);
        exit;
    }
}

<?php
namespace App\Controllers\Pdc;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Pdc\TrainingCategories;

class TrainingCategoriesController extends Controller
{
    private TrainingCategories $model;

    public function __construct()
    {
        if (!Auth::pdcCheck()) {
            header("Location: " . base_url('pdc/login'));
            exit;
        }
        $this->model = new TrainingCategories();
    }

    /** Main page */
    public function index(): void
    {
        $this->view('Pdc/TrainingCategory');
    }

    /** Fetch all for DataTables */
    public function fetch(): void
    {
        if (!Auth::pdcCheck()) {
            http_response_code(401);
            exit('Unauthorized: Please login as PDC.');
        }

        $categories = $this->model->getAll();
        json_response(['data' => $categories]);
    }

    /** Add new category */
    public function store(): void
    {
        if (!Auth::pdcCheck()) {
            http_response_code(401);
            exit('Unauthorized');
        }

        // ✅ CSRF check (function-based)
        if (!csrf_verify()) {
            http_response_code(403);
            json_response(['status' => 'error', 'message' => 'Invalid CSRF token.']);
            return;
        }

        $category_name = trim($_POST['category_name'] ?? '');
        if ($category_name === '') {
            json_response(['status' => 'error', 'message' => 'Category name is required.']);
            return;
        }

        $success = $this->model->create($category_name);

        json_response([
            'status' => $success ? 'success' : 'error',
            'message' => $success ? 'Category added successfully.' : 'Failed to add category.'
        ]);
    }

    /** Update existing category */
    public function update(): void
    {
        if (!Auth::pdcCheck()) {
            http_response_code(401);
            exit('Unauthorized');
        }

        if (!csrf_verify()) {
            http_response_code(403);
            json_response(['status' => 'error', 'message' => 'Invalid CSRF token.']);
            return;
        }

        $id = (int)($_POST['id'] ?? 0);
        $category_name = trim($_POST['category_name'] ?? '');

        if (!$id || $category_name === '') {
            json_response(['status' => 'error', 'message' => 'Invalid data.']);
            return;
        }

        $success = $this->model->update($id, $category_name);

        json_response([
            'status' => $success ? 'success' : 'error',
            'message' => $success ? 'Category updated successfully.' : 'Failed to update category.'
        ]);
    }

    /** Delete category */
    public function delete(): void
    {
        if (!Auth::pdcCheck()) {
            http_response_code(401);
            exit('Unauthorized');
        }

        if (!csrf_verify()) {
            http_response_code(403);
            json_response(['status' => 'error', 'message' => 'Invalid CSRF token.']);
            return;
        }

        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            json_response(['status' => 'error', 'message' => 'Invalid ID.']);
            return;
        }

        $success = $this->model->delete($id);

        json_response([
            'status' => $success ? 'success' : 'error',
            'message' => $success ? 'Category deleted successfully.' : 'Failed to delete category.'
        ]);
    }
}

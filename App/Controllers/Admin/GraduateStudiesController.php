<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Admin\GraduateStudies;
use App\Helpers\Auth;

class GraduateStudiesController extends Controller
{
    protected GraduateStudies $model;
    protected string $uploadDir;
    protected string $publicPath;

    public function __construct()
    {
        // ---------------- Admin Auth Check ----------------
        if (!Auth::adminCheck()) {
            header("Location: " . base_url('admin/login'));
            exit;
        }

        $this->uploadDir = dirname(__DIR__, 3) . '/public/assets/graduate_cert/';
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }

        $this->publicPath = base_url('public/assets/graduate_cert/');
        $this->model = new GraduateStudies();
    }

    /** Load view */
    public function index(): void
    {
        view_render('Admin/GraduateStudies');
    }

    /** Fast and secure JSON for DataTables */
    public function fetchAllJson(): void
    {
        try {
            $data = $this->model->getAll();
            json_response(['data' => $data]);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            json_response(['data' => [], 'error' => 'Failed to fetch data'], 500);
        }
    }

    /** Update record securely */
    public function update(): void
    {
        try {
            $id = (int)($_POST['id'] ?? 0);
            if (!$id) json_response(['success' => false, 'message' => 'Invalid ID'], 400);

            $fileName = $_POST['existing_file'] ?? null;

            if (!empty($_FILES['certification_file']['name'])) {
                $tmp = $_FILES['certification_file']['tmp_name'];
                $ext = strtolower(pathinfo($_FILES['certification_file']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                if (!in_array($ext, $allowed)) {
                    json_response(['success' => false, 'message' => 'Invalid file type'], 400);
                }

                $fileName = uniqid('grad_', true) . '.' . $ext;
                move_uploaded_file($tmp, $this->uploadDir . $fileName);
            }

            $data = [
                'institution_name' => trim($_POST['institution_name'] ?? ''),
                'graduate_course' => trim($_POST['graduate_course'] ?? ''),
                'year_graduated' => trim($_POST['year_graduated'] ?? ''),
                'units_earned' => trim($_POST['units_earned'] ?? ''),
                'specialization' => trim($_POST['specialization'] ?? ''),
                'honor_received' => trim($_POST['honor_received'] ?? ''),
                'certification_file' => $fileName
            ];

            $success = $this->model->update($id, $data);
            json_response(['success' => $success, 'message' => $success ? 'Updated successfully' : 'Update failed']);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            json_response(['success' => false, 'message' => 'Server error'], 500);
        }
    }

    /** Delete record + file */
    public function delete(): void
    {
        try {
            $id = (int)($_POST['id'] ?? 0);
            if (!$id) json_response(['success' => false, 'message' => 'Invalid ID'], 400);

            $grad = $this->model->getById($id);
            if ($grad && !empty($grad['certification_file'])) {
                $path = $this->uploadDir . basename($grad['certification_file']);
                if (file_exists($path)) unlink($path);
            }

            $success = $this->model->delete($id);
            json_response(['success' => $success, 'message' => $success ? 'Deleted successfully' : 'Delete failed']);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            json_response(['success' => false, 'message' => 'Server error'], 500);
        }
    }
}

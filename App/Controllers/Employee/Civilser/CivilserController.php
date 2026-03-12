<?php
namespace App\Controllers\Employee\Civilser;

use App\Core\EmployeeBaseController; // <-- extend base controller
use App\Helpers\Auth;
use App\Models\Employee\Civilser\Civilser as CivilserModel;

class CivilserController extends EmployeeBaseController
{
    protected CivilserModel $model;
    protected string $uploadDir;
    protected string $publicPath;

    public function __construct()
    {
        parent::__construct(); // <-- load sidebar globals

        $this->model = new CivilserModel();

        // Set upload directory and public path
        $this->uploadDir  = dirname(__DIR__, 4) . '/public/assets/civilser/';
        $this->publicPath = base_url('public/assets/civilser/');

        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0755, true);

        // Ensure employee is logged in
        if (!Auth::check()) {
            header("Location: " . base_url('employee/login'));
            exit;
        }
    }

    public function index()
    {
        return $this->view('Employee/Civilser/Civilser');
    }

    public function save()
    {
        $employee_id = Auth::id();

        if (empty($_POST['type'])) {
            return json_response(['success' => false, 'message' => 'Eligibility type is required'], 400);
        }

        // Handle file upload
        $proofFile = null;
        if (!empty($_FILES['proof']['name'])) {
            $proofFile = $this->uploadFile($_FILES['proof']);
            if (!$proofFile) {
                return json_response(['success' => false, 'message' => 'Failed to upload file'], 500);
            }
        }

        $eligibility = [
            'id' => $_POST['id'] ?? null,
            'type' => $_POST['type'],
            'rating' => $_POST['rating'] ?? null,
            'date' => $_POST['date'] ?? null,
            'place' => $_POST['place'] ?? null,
            'proof' => $proofFile,
            'existing_proof' => $_POST['existing_proof'] ?? ''
        ];

        $saved = $this->model->saveOrUpdate($employee_id, [$eligibility]);

        if ($saved) {
            $all = $this->model->getByEmployee($employee_id);
            return json_response(['success' => true, 'data' => $all, 'message' => 'Saved successfully']);
        }

        return json_response(['success' => false, 'message' => 'Failed to save'], 500);
    }

    public function get()
    {
        $employee_id = Auth::id();
        $all = $this->model->getByEmployee($employee_id);

        return json_response(['success' => true, 'data' => $all]);
    }

    public function delete()
    {
        $employee_id = Auth::id();
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['id'])) return json_response(['success' => false, 'message' => 'ID missing'], 400);

        $deleted = $this->model->delete((int)$data['id'], $employee_id);

        // Delete uploaded file if exists
        if ($deleted && !empty($data['file'])) {
            $filePath = $this->uploadDir . $data['file'];
            if (file_exists($filePath)) unlink($filePath);
        }

        return json_response(['success' => $deleted]);
    }

    private function uploadFile(array $file): ?string
    {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        if (!in_array(strtolower($ext), $allowed)) return null;

        $fileName = uniqid('civil_', true) . '.' . $ext;
        $dest = $this->uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $dest)) return $fileName;
        return null;
    }
}

<?php
namespace App\Controllers\Employee\Eduback;

use App\Core\EmployeeBaseController; // <-- extend base controller
use App\Helpers\Auth;
use App\Models\Employee\Eduback\GraduateStudies;

class GraduateStudiesController extends EmployeeBaseController
{
    protected GraduateStudies $model;
    protected ?string $employeeId;
    protected string $uploadDir;
    protected string $publicPath;

    public function __construct()
    {
        parent::__construct(); // <-- load sidebar globals

        $this->model = new GraduateStudies();
        $this->employeeId = Auth::id();

        if (!$this->employeeId) {
            header('Location: ' . base_url('employee/login'));
            exit;
        }

        $this->uploadDir = dirname(__DIR__, 4) . '/public/assets/graduate_cert/';
        $this->publicPath = base_url('public/assets/graduate_cert/');

        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0755, true);
    }

    public function index(): void
    {
        $this->view('Employee/Graduate/GraduateStudies');
    }

    public function get(): void
    {
        $id = $_GET['id'] ?? null;
        $data = $id 
            ? $this->model->findById((int)$id, $this->employeeId)
            : $this->model->getAllByEmpId($this->employeeId);

        json_response([
            'success' => true,
            'message' => 'Data fetched successfully',
            'data' => $data
        ]);
    }

    public function save(): void
    {
        $id = $_POST['id'] ?? null;
        $existingFile = $_POST['existing_file'] ?? '';
        $fileName = $this->handleFileUpload($existingFile);

        $success = $this->model->saveRecord(
            $this->employeeId,
            $id ? (int)$id : null,
            $_POST['institution_name'] ?? '',
            $_POST['graduate_course'] ?? '',
            $_POST['year_graduated'] ?? null,
            $_POST['units_earned'] ?? null,
            $_POST['specialization'] ?? null,
            $_POST['honor_received'] ?? null,
            $fileName
        );

        json_response([
            'success' => $success,
            'message' => $success ? 'Saved successfully.' : 'Failed to save record.'
        ]);
    }

    public function delete(): void
    {
        $id = $_POST['id'] ?? 0;
        if (!$id) json_response(['success'=>false,'message'=>'Invalid ID']);

        $record = $this->model->findById((int)$id, $this->employeeId);
        if (!$record) json_response(['success'=>false,'message'=>'Record not found']);

        if (!empty($record['certification_file'])){
            $file = $this->uploadDir . $record['certification_file'];
            if (file_exists($file)) unlink($file);
        }

        $success = $this->model->deleteById((int)$id, $this->employeeId);
        json_response([
            'success' => $success,
            'message' => $success ? 'Deleted successfully.' : 'Delete failed.'
        ]);
    }

    private function handleFileUpload(string $existingFile = ''): string
    {
        if (empty($_FILES['certification_file']['name'])) return $existingFile;

        $ext = pathinfo($_FILES['certification_file']['name'], PATHINFO_EXTENSION);
        $fileName = preg_replace('/[^a-zA-Z0-9_-]/','',$this->employeeId.'_'.uniqid()).'.'.$ext;
        $target = $this->uploadDir . $fileName;

        return move_uploaded_file($_FILES['certification_file']['tmp_name'], $target) ? $fileName : $existingFile;
    }
}

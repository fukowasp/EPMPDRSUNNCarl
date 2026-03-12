<?php
namespace App\Controllers\Employee\Otherinfo;

use App\Core\EmployeeBaseController;
use App\Helpers\Auth;
use App\Models\Employee\Otherinfo\Otherinfo;

class OtherinfoController extends EmployeeBaseController
{
    protected Otherinfo $model;
    protected string $uploadDir;
    protected string $publicPath;

    protected array $tables = [
        'skills_hobbies' => 'Skill',
        'distinctions'   => 'Recognition',
        'membership'     => 'Membership'
    ];

    public function __construct()
    {
        parent::__construct(); // Ensures employee session and sidebar data

        $this->model = new Otherinfo();

        $this->uploadDir  = dirname(__DIR__, 4) . '/public/assets/membership_proof/';
        $this->publicPath = base_url('public/assets/membership_proof/');

        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0755, true);
    }

    public function index(): void
    {
        $employee_id = Auth::id();
        $otherInfos = $this->model->getAllByEmployee($employee_id);

        $this->view('Employee/Otherinfo/Otherinfo', [
            'otherInfos' => $otherInfos
        ]);
    }

    public function save(): void
    {
        if (!csrf_verify()) {
            json_response(['success' => false, 'message' => 'CSRF token mismatch.', 'csrf_token' => csrf_token()]);
        }

        $employee_id = Auth::id();
        $id = $_POST['info_id'] ?? null;

        // Handle file upload
        $proofFile = null;

if (isset($_FILES['proof_membership']) && $_FILES['proof_membership']['name'] !== '') {
    $proofFile = $this->uploadFile($_FILES['proof_membership']);
    if (!$proofFile) {
        json_response(['success' => false, 'message' => 'Invalid or failed file upload.']);
    }
} else {
    $proofFile = $_POST['existing_proof'] ?? null;
}


        $success = true;
        foreach ($this->tables as $field => $type) {
            $method = $id ? "update$type" : "insert$type";
            $res = $id ? $this->model->$method($id, $_POST[$field] ?? '', $proofFile)
                       : $this->model->$method($employee_id, $_POST[$field] ?? '', $proofFile);
            if (!$res) $success = false;
        }

        json_response([
            'success' => $success,
            'message' => $success ? "Saved successfully" : "Failed to save",
            'csrf_token' => csrf_token()
        ]);
    }

    public function delete(): void
    {
        if (!csrf_verify()) {
            json_response(['success' => false, 'message' => 'CSRF token mismatch.', 'csrf_token' => csrf_token()]);
        }

        $id = $_POST['id'] ?? null;
        if (!$id) json_response(['success' => false, 'message' => 'Invalid request.']);

        $proof = $this->model->getMembershipById($id)['proof_membership'] ?? null;
        $success = true;

        foreach ($this->tables as $field => $type) {
            if (!$this->model->{"delete$type"}($id)) $success = false;
        }

        if ($success && $proof) {
            $filePath = $this->uploadDir . $proof;
            if (file_exists($filePath)) unlink($filePath);
        }

        json_response([
            'success' => $success,
            'message' => $success ? "Deleted successfully" : "Failed to delete",
            'csrf_token' => csrf_token()
        ]);
    }

    public function get(): void
    {
        if (!csrf_verify($_GET['_csrf_token'] ?? null)) {
            json_response(['success' => false, 'message' => 'CSRF token mismatch.', 'csrf_token' => csrf_token()]);
        }

        $id = $_GET['id'] ?? null;
        if (!$id) json_response(['success' => false, 'message' => 'Invalid request.']);

        $data = [
            'skills_hobbies' => $this->model->getSkillById($id)['skill_hobby'] ?? '',
            'distinctions'   => $this->model->getRecognitionById($id)['recognition'] ?? '',
            'membership'     => $this->model->getMembershipById($id)['membership'] ?? '',
            'proof_membership' => $this->model->getMembershipById($id)['proof_membership'] ?? null
        ];

        json_response(['success' => true, 'data' => $data, 'csrf_token' => csrf_token()]);
    }

    private function uploadFile(array $file): ?string
    {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        if (!in_array($ext, $allowed)) return null;

        $fileName = uniqid('mem_', true) . '.' . $ext;
        $dest = $this->uploadDir . $fileName;
        return move_uploaded_file($file['tmp_name'], $dest) ? $fileName : null;
    }

    public function searchSkills(): void
    {
        $query = trim($_GET['q'] ?? '');
        if ($query === '') {
            json_response(['success' => true, 'data' => [], 'csrf_token' => csrf_token()]);
        }

        $file = $_SERVER['DOCUMENT_ROOT'] . '/EPMPDRSUNN/public/all_data_skill_and_nonskills/all_data_skill_and_nonskills.csv';
        if (!file_exists($file)) {
            json_response(['success' => false, 'message' => 'CSV file not found.', 'csrf_token' => csrf_token()]);
        }

        $results = [];
        if (($handle = fopen($file, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                foreach ($row as $skill) {
                    if (stripos($skill, $query) !== false) {
                        $results[$skill] = true;
                        if (count($results) >= 20) break 2;
                    }
                }
            }
            fclose($handle);
        }

        json_response(['success' => true, 'data' => array_keys($results), 'csrf_token' => csrf_token()]);
    }
}

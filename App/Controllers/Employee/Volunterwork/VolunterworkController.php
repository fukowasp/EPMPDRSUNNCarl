<?php
namespace App\Controllers\Employee\Volunterwork;

use App\Core\EmployeeBaseController;
use App\Helpers\Auth;
use App\Models\Employee\Volunterwork\Volunterwork;

class VolunterworkController extends EmployeeBaseController
{
    protected Volunterwork $model;
    protected ?string $employeeId = null; 
    protected string $uploadDir;
    protected string $publicPath;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Volunterwork();
        $this->employeeId = Auth::id();

        if (!$this->employeeId) {
            header('Location: ' . base_url('employee/login'));
            exit;
        }

        $this->uploadDir = dirname(__DIR__, 4) . '/public/assets/voluntarywork/';
        $this->publicPath = base_url('public/assets/voluntarywork/');

        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0755, true);
    }

    public function index(): void
    {
        $this->view('Employee/Volunterwork/Volunterwork');
    }

    public function get(): void
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $work = $this->model->findById($id, $this->employeeId);
            if ($work) {
                $work['membership_id_url'] = $work['membership_id_url'] ?? '';
                json_response([
                    'success' => true,
                    'message' => 'Data fetched',
                    'data' => $work
                ]);
            } else {
                json_response([
                    'success' => false,
                    'message' => 'Work not found'
                ]);
            }
        } else {
            $data = $this->model->getByEmployee($this->employeeId);
            foreach ($data as &$work) {
                $work['membership_id_url'] = $work['membership_id_url'] ?? '';
            }

            json_response([
                'success' => true,
                'message' => 'Data fetched',
                'voluntarywork' => $data
            ]);
        }
    }

    public function save(): void
    {
        $id       = $_POST['id'] ?? null;
        $orgName  = $_POST['organization_name'] ?? '';
        $role     = $_POST['position_role'] ?? '';
        $address  = $_POST['organization_address'] ?? '';
        $from     = $_POST['service_from'] ?? null;
        $to       = $_POST['service_to'] ?? null;
        $hours    = $_POST['number_of_hours'] ?? 0;
        $existing = $_POST['existing_files'] ?? '';

        // Handle file uploads
        $uploadedFiles = [];
        if (!empty($_FILES['proof_files']['name'][0])) {
            foreach ($_FILES['proof_files']['name'] as $index => $name) {
                if (empty($name)) continue;
                $tmpName = $_FILES['proof_files']['tmp_name'][$index];
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $fileName = preg_replace('/[^a-zA-Z0-9_-]/', '', $this->employeeId . '_' . uniqid()) . '.' . $ext;
                
                // Allow images and PDFs
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
                if (in_array($ext, $allowedExts)) {
                    if (move_uploaded_file($tmpName, $this->uploadDir . $fileName)) {
                        $uploadedFiles[] = $fileName;
                    }
                }
            }
        }

        $allFilesStr = implode(',', array_filter(array_merge(explode(',', $existing), $uploadedFiles)));

        $work = [
            'id'                   => $id,
            'organization_name'    => $orgName,
            'position_role'        => $role,
            'organization_address' => $address,
            'start_date'           => $from,
            'end_date'             => $to,
            'number_of_hours'      => $hours,
            'membership_id_url'    => $allFilesStr
        ];

        $success = $this->model->save($this->employeeId, [$work]);

        json_response([
            'success' => $success,
            'message' => $success ? 'Saved successfully' : 'Failed to save'
        ]);
    }

    public function deleteWork(): void
    {
        $id = $_POST['id'] ?? 0;
        $work = $this->model->findById($id, $this->employeeId);

        if ($work && !empty($work['membership_id_url'])) {
            $files = explode(',', $work['membership_id_url']);
            foreach ($files as $file) {
                $filePath = $this->uploadDir . basename($file);
                if (file_exists($filePath)) unlink($filePath);
            }
        }

        $success = $this->model->deleteById($id, $this->employeeId);

        json_response([
            'success' => $success,
            'message' => $success ? 'Deleted successfully' : 'Failed to delete'
        ]);
    }
}
<?php
namespace App\Controllers\Employee\Info;

use App\Core\EmployeeBaseController; // EXTEND the base controller!
use App\Helpers\Auth;
use App\Models\Employee\Info\Info;

class InfoController extends EmployeeBaseController
{
    protected Info $infoModel;

    private int $maxPhotoSize = 2 * 1024 * 1024; // 2 MB
    private array $allowedPhotoTypes = ['image/jpeg', 'image/png', 'image/webp'];

    public function __construct()
    {
        parent::__construct(); // <<< THIS LOADS GLOBAL EMPLOYEE DATA

        $this->infoModel = new Info();
    }

    // Render view
    public function index()
    {
        if (!Auth::check()) {
            header("Location: " . base_url('employee/login'));
            exit;
        }

        $employee = Auth::user();
        $personalInfo = $this->infoModel->getByEmployeeId($employee['employee_id']);

        // Use $this->view() so sidebar gets global data
        $this->view('Employee/Info/Info', [
            'personalInfo' => $personalInfo
        ]);
    }

    // Get JSON data
    public function get()
    {
        header('Content-Type: application/json');
        $employee = Auth::user();
        if (!$employee) {
            echo json_encode(["success" => false, "error" => "Unauthorized"]);
            return;
        }

        $data = $this->infoModel->getByEmployeeId($employee['employee_id']);
        if (!$data) $data = [];

        // Add Base64 photo
        if (!empty($data['employee_photo'])) {
            $filePath = __DIR__ . '/../../../uploads/employee_photos/' . $data['employee_photo'];
            if (file_exists($filePath)) {
                $mimeType = mime_content_type($filePath);
                $data['employee_photo_base64'] = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($filePath));
            }
        }

        echo json_encode([
            "success" => true,
            "data" => $data
        ]);
    }

    // Save personal info
    public function save()
    {
        header('Content-Type: application/json');
        $employee = Auth::user();
        if (!$employee) {
            echo json_encode(["success" => false, "error" => "Unauthorized"]);
            return;
        }

        $employeeId = $employee['employee_id'];
        $data = $_POST;

        // Handle file upload
        if (isset($_FILES['employee_photo']) && $_FILES['employee_photo']['tmp_name']) {
            $file = $_FILES['employee_photo'];

            // Validate file size
            if ($file['size'] > $this->maxPhotoSize) {
                echo json_encode(["success" => false, "error" => "Photo must be less than 2MB"]);
                return;
            }

            // Validate MIME type
            $mimeType = mime_content_type($file['tmp_name']);
            if (!in_array($mimeType, $this->allowedPhotoTypes)) {
                echo json_encode(["success" => false, "error" => "Invalid file type. Only JPG, PNG, or WEBP allowed"]);
                return;
            }

            $uploadDir = __DIR__ . '/../../../uploads/employee_photos/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $fileName = $employeeId . '_' . time() . '_' . basename($file['name']);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $data['employee_photo'] = $fileName;
            }
        }

        $data['employee_id'] = $employeeId;

        try {
            $saved = $this->infoModel->save($data);
            echo json_encode([
                "success" => $saved,
                "message" => $saved ? "Personal info saved successfully." : "Failed to save personal info.",
                "data" => $this->infoModel->getByEmployeeId($employeeId) // return full updated info
            ]);
        } catch (\PDOException $e) {
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }
}

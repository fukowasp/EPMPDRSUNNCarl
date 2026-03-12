<?php
namespace App\Controllers\Employee\Learndev;

use App\Core\EmployeeBaseController;
use App\Helpers\Auth;
use App\Models\Employee\Learndev\Learndev;

/**
 * Learning and Development Controller
 * Handles employee training program management with authentication and validation
 */
class LearndevController extends EmployeeBaseController
{
    protected Learndev $model;
    protected string $uploadDir;
    protected string $publicPath;

    public function __construct()
    {
        parent::__construct(); // Loads $globalEmployeeData

        $this->model = new Learndev();
        $this->uploadDir = dirname(__DIR__, 4) . '/public/assets/learndev/';
        $this->publicPath = base_url('public/assets/learndev/');

        // Create upload directory if it doesn't exist
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    /**
     * Display the learning and development page
     */
    public function index(): void
    {
        // Check authentication - redirect to login if not authenticated
        if (!Auth::check()) {
            header('Location: ' . base_url('employee/login'));
            exit;
        }
        
        $this->view('Employee/Learndev/Learndev');
    }

    /**
     * Get learning and development records
     * Returns all records for the employee, or a single record if ?id= is provided
     */
    public function get(): void
    {
        // Check authentication - return 401 if not authenticated
        if (!Auth::check()) {
            json_response(['success' => false, 'error' => 'Unauthorized. Please login.'], 401);
            return;
        }
        
        $employee_id = Auth::id();
        
        // Check if ID is provided via query parameter
        $id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;
        
        // If ID is provided, get single record
        if ($id) {
            $data = $this->model->getById($id, $employee_id);
            if (!$data) {
                json_response(['success' => false, 'error' => 'Record not found'], 404);
                return;
            }
            json_response(['success' => true, 'data' => $data]);
        } else {
            // Get all records for employee
            $data = $this->model->allByEmployee($employee_id);
            json_response(['success' => true, 'data' => $data]);
        }
    }

    /**
     * Save (create or update) a learning and development record
     */
    public function save(): void
    {
        // Check authentication
        if (!Auth::check()) {
            json_response(['success' => false, 'error' => 'Unauthorized. Please login.'], 401);
            return;
        }
        
        $employee_id = Auth::id();
        
        // Sanitize and validate input
        $ld_title = $this->sanitizeInput($_POST['ld_title'] ?? '');
        $ld_date_from = $this->sanitizeInput($_POST['ld_date_from'] ?? '');
        $ld_date_to = $this->sanitizeInput($_POST['ld_date_to'] ?? '');
        $ld_hours = filter_var($_POST['ld_hours'] ?? 0, FILTER_VALIDATE_INT);
        $ld_type = $this->sanitizeInput($_POST['ld_type'] ?? '');
        $ld_sponsor = $this->sanitizeInput($_POST['ld_sponsor'] ?? '');
        $ld_id = !empty($_POST['ld_id']) ? filter_var($_POST['ld_id'], FILTER_VALIDATE_INT) : null;
        
        // Validation
        if (empty($ld_title)) {
            json_response(['success' => false, 'error' => 'Training title is required'], 400);
            return;
        }
        
        if (empty($ld_date_from) || empty($ld_date_to)) {
            json_response(['success' => false, 'error' => 'Date range is required'], 400);
            return;
        }
        
        if (!$this->isValidDate($ld_date_from) || !$this->isValidDate($ld_date_to)) {
            json_response(['success' => false, 'error' => 'Invalid date format'], 400);
            return;
        }
        
        if (strtotime($ld_date_from) > strtotime($ld_date_to)) {
            json_response(['success' => false, 'error' => 'End date must be after start date'], 400);
            return;
        }
        
        if (!$ld_hours || $ld_hours < 1) {
            json_response(['success' => false, 'error' => 'Valid number of hours is required'], 400);
            return;
        }
        
        if (empty($ld_type)) {
            json_response(['success' => false, 'error' => 'Training type is required'], 400);
            return;
        }
        
        if (empty($ld_sponsor)) {
            json_response(['success' => false, 'error' => 'Sponsor information is required'], 400);
            return;
        }

        // Handle file upload
        $file_name = null;
        if (!empty($_FILES['ld_certification']['name'])) {
            $upload_result = $this->handleFileUpload($_FILES['ld_certification']);
            if (!$upload_result['success']) {
                json_response(['success' => false, 'error' => $upload_result['error']], 400);
                return;
            }
            $file_name = $upload_result['filename'];
            
            // Delete old file if updating
            if ($ld_id) {
                $existing = $this->model->getById($ld_id, $employee_id);
                if ($existing && !empty($existing['ld_certification'])) {
                    $old_file = $this->uploadDir . basename($existing['ld_certification']);
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
            }
        } else if ($ld_id) {
            // If editing and no new file, keep existing
            $existing = $this->model->getById($ld_id, $employee_id);
            $file_name = $existing['ld_certification'] ?? null;
        }

        $data = [
            ':employee_id' => $employee_id,
            ':ld_title' => $ld_title,
            ':ld_date_from' => $ld_date_from,
            ':ld_date_to' => $ld_date_to,
            ':ld_hours' => $ld_hours,
            ':ld_type' => $ld_type,
            ':ld_sponsor' => $ld_sponsor,
            ':ld_certification' => $file_name
        ];

        try {
            if ($ld_id) {
                $result = $this->model->updateProgram($ld_id, $employee_id, $data);
                $message = 'Training program updated successfully';
            } else {
                $result = $this->model->create($data);
                $message = 'Training program added successfully';
            }
            
            if ($result) {
                json_response(['success' => true, 'message' => $message]);
            } else {
                json_response(['success' => false, 'error' => 'Failed to save record'], 500);
            }
        } catch (\Exception $e) {
            json_response(['success' => false, 'error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete a learning and development record
     */
    public function delete(): void
    {
        // Check authentication
        if (!Auth::check()) {
            json_response(['success' => false, 'error' => 'Unauthorized. Please login.'], 401);
            return;
        }
        
        $employee_id = Auth::id();
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        
        if (!$id) {
            json_response(['success' => false, 'error' => 'Invalid ID'], 400);
            return;
        }

        // Get record to delete file
        $record = $this->model->getById($id, $employee_id);
        if (!$record) {
            json_response(['success' => false, 'error' => 'Record not found'], 404);
            return;
        }

        // Delete file if exists
        if (!empty($record['ld_certification'])) {
            $file = $this->uploadDir . basename($record['ld_certification']);
            if (file_exists($file)) {
                unlink($file);
            }
        }

        try {
            $result = $this->model->deleteProgram($id, $employee_id);
            if ($result) {
                json_response(['success' => true, 'message' => 'Record deleted successfully']);
            } else {
                json_response(['success' => false, 'error' => 'Failed to delete record'], 500);
            }
        } catch (\Exception $e) {
            json_response(['success' => false, 'error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Sanitize input to prevent XSS attacks
     * 
     * @param string $input Raw input string
     * @return string Sanitized string
     */
    private function sanitizeInput(string $input): string
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate date format (Y-m-d)
     * 
     * @param string $date Date string to validate
     * @return bool True if valid, false otherwise
     */
    private function isValidDate(string $date): bool
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    /**
     * Handle file upload with comprehensive validation
     * 
     * @param array $file File array from $_FILES
     * @return array ['success' => bool, 'filename' => string, 'error' => string]
     */
    private function handleFileUpload(array $file): array
    {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'File upload error'];
        }

        // Validate file size (max 5MB)
        $max_size = 5 * 1024 * 1024;
        if ($file['size'] > $max_size) {
            return ['success' => false, 'error' => 'File size exceeds 5MB limit'];
        }

        // Validate file type using MIME type detection
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'application/pdf'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime_type, $allowed_types)) {
            return ['success' => false, 'error' => 'Invalid file type. Only images and PDF allowed'];
        }

        // Validate file extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        
        if (!in_array($ext, $allowed_extensions)) {
            return ['success' => false, 'error' => 'Invalid file extension'];
        }

        // Generate secure filename with unique ID
        $file_name = uniqid('cert_', true) . '.' . $ext;
        $full_path = $this->uploadDir . $file_name;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $full_path)) {
            return ['success' => false, 'error' => 'Failed to save file'];
        }

        // Set proper file permissions
        chmod($full_path, 0644);

        return ['success' => true, 'filename' => $file_name];
    }
}
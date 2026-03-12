<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Admin\EmployeeList;

class EmployeeListController extends Controller
{
    protected EmployeeList $employeeModel;
    protected string $uploadDirGrad;
    protected string $uploadDirVoluntary;
    protected string $uploadDirCivil;

    public function __construct()
    {
        $this->employeeModel = new EmployeeList();

        if (!Auth::adminCheck()) {
            header("Location: " . base_url('admin/login'));
            exit;
        }

        // Set upload directories — realpath will normalize the slashes
        $baseDir = dirname(__DIR__, 3);
        
        $this->uploadDirVoluntary = realpath($baseDir . '/public/assets/voluntarywork') . DIRECTORY_SEPARATOR;
        $this->uploadDirGrad      = realpath($baseDir . '/public/assets/graduate_cert') . DIRECTORY_SEPARATOR;
        $this->uploadDirCivil     = realpath($baseDir . '/public/assets/civilser') . DIRECTORY_SEPARATOR;

        // Create directories if they don't exist
        if (!is_dir($this->uploadDirGrad)) mkdir($this->uploadDirGrad, 0755, true);
        if (!is_dir($this->uploadDirVoluntary)) mkdir($this->uploadDirVoluntary, 0755, true);
        if (!is_dir($this->uploadDirCivil)) mkdir($this->uploadDirCivil, 0755, true);
    }


    protected function jsonResponse($status, $message, $data = [], int $code = 200)
    {
        http_response_code($code);
        header("Content-Type: application/json");
        echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
        exit;
    }

    // ----------------------
    // Main index page
    // ----------------------

    public function index()
    {
        return $this->view('Admin/EmployeeList');
    }



    // ----------------------
    // Fetch all employees for datatable
    // ----------------------
    public function fetchAllJson()
    {
        $draw = (int)($_GET['draw'] ?? 0);
        $search = $_GET['search']['value'] ?? null;
        $start = (int)($_GET['start'] ?? 0);
        $length = (int)($_GET['length'] ?? 200);

        $result = $this->employeeModel->getAll($length, $start, $search);

        header("Content-Type: application/json");
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $result['pagination']['total'],
            "recordsFiltered" => $result['pagination']['total'], // change if you implement filtering count separately
            "data" => $result['rows']
        ]);
        exit;
    }

    // ----------------------
    // Fetch single employee (full PDS)
    // ----------------------
    public function getEmployee()
    {
        $id = $_GET['employee_id'] ?? null;
        if (!$id) $this->jsonResponse("error", "Missing employee_id");

        $data = $this->employeeModel->getEmployee($id);
        if (!$data) $this->jsonResponse("error", "Employee not found", [], 404);

        $this->jsonResponse("success", "Employee fetched", $data);
    }

    // ----------------------
    // Update full employee info
    // ----------------------
    public function updateEmployee()
    {
        $id = $_POST['employee_id'] ?? null;
        if (!$id) $this->jsonResponse("error", "Missing employee_id");

        $input = $_POST;
        $files = $_FILES;

        // ==========================
        // HANDLE GRADUATE CERT UPLOAD
        // ==========================
        if (!empty($files['certification_file']['name'])) {
            foreach ($files['certification_file']['tmp_name'] as $i => $tmpName) {
                if ($tmpName === "") continue;

                $ext = pathinfo($files['certification_file']['name'][$i], PATHINFO_EXTENSION);
                $filename = time() . '_' . uniqid() . '.' . $ext;
                $target = $this->uploadDirGrad . $filename;

                if (move_uploaded_file($tmpName, $target)) {
                    $input['certification_file'][$i] = $filename; 
                }
            }
        }
        
        // ==========================
        // HANDLE VOLUNTARY WORK FILE
        // ==========================
        if (!empty($files['membership_id_url']['name']) && $files['membership_id_url']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($files['membership_id_url']['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $target = $this->uploadDirVoluntary . $filename;

            if (move_uploaded_file($files['membership_id_url']['tmp_name'], $target)) {
                $input['membership_id_url'] = $filename;
            }
        }

        // ==========================
        // HANDLE CIVIL SERVICE PROOF
        // ==========================
        if (!empty($files['proof_of_certification']['name']) && $files['proof_of_certification']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($files['proof_of_certification']['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $target = $this->uploadDirCivil . $filename;

            if (move_uploaded_file($files['proof_of_certification']['tmp_name'], $target)) {
                $input['proof_of_certification'] = $filename;
            }
        }

        // ==========================
        // HANDLE LEARNING DEVELOPMENT FILE
        // ==========================
        if (!empty($files['ld_certification']['name']) && $files['ld_certification']['error'] === UPLOAD_ERR_OK) {
            // Create directory if doesn't exist
            $uploadDirLD = dirname(__DIR__, 3) . '/public/assets/learndev/';
            if (!is_dir($uploadDirLD)) mkdir($uploadDirLD, 0755, true);
            
            $ext = pathinfo($files['ld_certification']['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $target = $uploadDirLD . $filename;

            if (move_uploaded_file($files['ld_certification']['tmp_name'], $target)) {
                $input['ld_certification'] = $filename;
            }
        }

        // Update employee
        $this->employeeModel->updateEmployee($id, $input);

        // Fetch full updated employee data
        $updatedEmployee = $this->employeeModel->getEmployee($id);

        // Return updated data in JSON
        $this->jsonResponse("success", "Employee updated successfully", $updatedEmployee);
    }

    // ----------------------
    // Delete Graduate Study
    // ----------------------
    public function deleteGraduateStudy()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) $this->jsonResponse("error", "Missing graduate study ID");

        $result = $this->employeeModel->deleteGraduateStudy($id);
        
        if ($result) {
            $this->jsonResponse("success", "Graduate study deleted successfully");
        } else {
            $this->jsonResponse("error", "Failed to delete graduate study", [], 500);
        }
    }

    // ----------------------
    // Delete Civil Service
    // ----------------------
    public function deleteCivilService()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) $this->jsonResponse("error", "Missing civil service ID");

        $result = $this->employeeModel->deleteCivilService($id);
        
        if ($result) {
            $this->jsonResponse("success", "Civil service eligibility deleted successfully");
        } else {
            $this->jsonResponse("error", "Failed to delete civil service eligibility", [], 500);
        }
    }

    // ----------------------
    // Delete Work Experience
    // ----------------------
    public function deleteWorkExperience()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) $this->jsonResponse("error", "Missing work experience ID");

        $result = $this->employeeModel->deleteWorkExperience($id);
        
        if ($result) {
            $this->jsonResponse("success", "Work experience deleted successfully");
        } else {
            $this->jsonResponse("error", "Failed to delete work experience", [], 500);
        }
    }

    // ----------------------
    // Delete Voluntary Work
    // ----------------------
    public function deleteVoluntaryWork()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) $this->jsonResponse("error", "Missing voluntary work ID");

        $result = $this->employeeModel->deleteVoluntaryWork($id);
        
        if ($result) {
            $this->jsonResponse("success", "Voluntary work deleted successfully");
        } else {
            $this->jsonResponse("error", "Failed to delete voluntary work", [], 500);
        }
    }

    // ----------------------
    // Delete Learning Development
    // ----------------------
    public function deleteLearningDevelopment()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) $this->jsonResponse("error", "Missing learning development ID");

        $result = $this->employeeModel->deleteLearningDevelopment($id);
        
        if ($result) {
            $this->jsonResponse("success", "Learning & development program deleted successfully");
        } else {
            $this->jsonResponse("error", "Failed to delete learning & development program", [], 500);
        }
    }

 
    // ----------------------
    // Delete Employee
    // ----------------------
    public function delete()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $employeeId = $input['employee_id'] ?? null;
        
        if (!$employeeId) {
            $this->jsonResponse("error", "Missing employee_id", [], 400);
        }

        try {
            // Delete from all related tables first (foreign key constraints)
            $this->employeeModel->deleteEmployee($employeeId);
            
            $this->jsonResponse("success", "Employee deleted successfully");
        } catch (\Exception $e) {
            error_log("Delete employee failed: " . $e->getMessage());
            $this->jsonResponse("error", "Failed to delete employee: " . $e->getMessage(), [], 500);
        }
    }

    public function servePDF()
    {
        // Disable error display
        error_reporting(E_ALL);
        ini_set('display_errors', 0);

        $file = $_GET['file'] ?? null;
        $type = $_GET['type'] ?? 'voluntarywork';

        if (!$file) {
            http_response_code(400);
            die("No file specified");
        }

        // Sanitize file name
        $file = basename($file);

        // Base directory
        $baseDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;

        $typeDirs = [
            'voluntarywork' => 'voluntarywork',
            'graduate'      => 'graduate_cert',
            'civil'         => 'civilser',
            'learning'      => 'learndev'
        ];

        $subDir = $typeDirs[$type] ?? 'voluntarywork';
        $filePath = $baseDir . $subDir . DIRECTORY_SEPARATOR . $file;

        if (!file_exists($filePath)) {
            http_response_code(404);
            die("File not found");
        }

        if (!is_readable($filePath)) {
            http_response_code(403);
            die("File not readable");
        }

        $fileSize = filesize($filePath);

        // Stop all output buffering
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Disable gzip compression
        if (function_exists('apache_setenv')) {
            @apache_setenv('no-gzip', '1');
        }
        @ini_set('zlib.output_compression', 'Off');

        // Send headers
        header('Content-Type: application/pdf');
        header('Content-Length: ' . $fileSize);
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        // Output file in chunks
        $handle = fopen($filePath, 'rb');
        if ($handle) {
            while (!feof($handle)) {
                echo fread($handle, 8192);
                flush();
            }
            fclose($handle);
        }

        exit(0);
    }

    public function deleteOtherInformation()
    {
        $id = $_POST['id'] ?? null;
        $type = $_POST['type'] ?? null;
        
        if (!$id || !$type) {
            $this->jsonResponse("error", "Missing ID or type");
        }

        $result = $this->employeeModel->deleteOtherInformation($id, $type);
        
        if ($result) {
            $this->jsonResponse("success", "Other information deleted successfully");
        } else {
            $this->jsonResponse("error", "Failed to delete other information", [], 500);
        }
    }

}
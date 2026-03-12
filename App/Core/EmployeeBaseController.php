<?php
namespace App\Core;

use App\Helpers\Auth;
use App\Models\Employee\Info\Info;

class EmployeeBaseController
{
    protected array $globalEmployeeData = [];
    protected Info $infoModel;

    public function __construct()
    {   
        // Ensure session is active
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        // Load Info model
        $this->infoModel = new Info();

        // Load global employee data for sidebar
        $this->loadEmployeeGlobals();
    }

    /**
     * Load logged-in employee info (name, ID, department, photo)
     */
    protected function loadEmployeeGlobals(): void
    {
        if (!Auth::check()) return;

        // Get user data from Auth::user() which has fallback logic
        $user = Auth::user();
        
        // TEMPORARY DEBUG - Remove after testing
        error_log('=== DEBUG Auth::user() ===');
        error_log('User data: ' . print_r($user, true));
        error_log('========================');
        
        if (!$user) return;

        $employeeId = $user['employee_id'] ?? null;
        if (!$employeeId) return;

        $this->globalEmployeeData = [
            'employeeName' => trim(($user['first_name'] ?? '') . ' ' . ($user['surname'] ?? '')),
            'personalInfo' => [
                'employee_id' => $employeeId,
                'department' => $user['department'] ?? 'Department',
                'employee_photo_base64' => '',
            ]
        ];

        // TEMPORARY DEBUG - Remove after testing
        error_log('=== DEBUG globalEmployeeData ===');
        error_log('Data: ' . print_r($this->globalEmployeeData, true));
        error_log('================================');

        // Convert photo to Base64 if exists
        if (!empty($user['employee_photo'])) {
            $filePath = __DIR__ . '/../../uploads/employee_photos/' . $user['employee_photo'];
            if (file_exists($filePath)) {
                $mimeType = mime_content_type($filePath);
                $this->globalEmployeeData['personalInfo']['employee_photo_base64'] =
                    'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($filePath));
            }
        }
    }

    /**
     * Render a view with global employee data automatically
     */
    protected function view(string $view, array $data = []): void
    {
        $data = array_merge($this->globalEmployeeData, $data);
        view_render($view, $data);
    }

    /**
     * Send JSON response
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        json_response($data, $statusCode);
    }
}
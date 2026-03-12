<?php
namespace App\Controllers\Pdc;

use App\Core\Controller;
use App\Helpers\Auth;
use App\Models\Pdc\EmployeeList;

class EmployeeListController extends Controller
{
    protected EmployeeList $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeList();

        // Ensure only PDC users can access
        if (!Auth::pdcCheck()) {
            header("Location: " . base_url('pdc/login'));
            exit;
        }
    }

    // ==========================
    // Employee List Page
    // ==========================
    public function index()
    {
        return $this->view('Pdc/EmployeeList');
    }

    // ==========================
    // Fetch Employees (JSON)
    // ==========================
public function fetchAllJson()
{
    header('Content-Type: application/json; charset=utf-8');

    $search = $_GET['search']['value'] ?? '';
    $limit  = isset($_GET['length']) ? (int)$_GET['length'] : 200;
    $offset = isset($_GET['start']) ? (int)$_GET['start'] : 0;

    try {
        $result = $this->employeeModel->getAll($limit, $offset, $search);

        echo json_encode([
            'status' => 'success',
            'rows'   => $result['rows'],
            'total'  => $result['total']
        ]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
    }
    exit;
}



    // ==========================
    // View PDS of an employee
    // ==========================
    public function viewPDS()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            return json_response(['status' => 'error', 'message' => 'Missing employee ID'], 400);
        }

        $data = $this->employeeModel->getEmployeePDS($id);

        if (empty($data)) {
            return json_response(['status' => 'error', 'message' => 'Employee not found'], 404);
        }

        return json_response(['status' => 'success', 'data' => $data]);
    }
}

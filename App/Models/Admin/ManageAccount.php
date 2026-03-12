<?php
namespace App\Models\Admin;

use App\Core\Database;
use PDO;

class ManageAccount
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT id, employee_id, department, academic_rank, employment_type, created_at 
            FROM employee_register 
            ORDER BY id DESC
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        json_response(['rows' => $rows]);
    }

    public function save(array $data)
    {
        $id = (int)($data['id'] ?? 0);
        $employee_id = trim($data['employee_id'] ?? '');
        $department = trim($data['department'] ?? '');
        $academic_rank = trim($data['academic_rank'] ?? '');
        $employment_type = trim($data['employment_type'] ?? '');
        $password = trim($data['password'] ?? '');

        // Validation
        if (!$employee_id || !$department || !$academic_rank || !$employment_type || (!$id && !$password)) {
            json_response(['success' => false, 'message' => 'All required fields must be filled'], 400);
        }

        try {
            if ($id) {
                // Update
                $sql = "
                    UPDATE employee_register
                    SET employee_id = :employee_id,
                        department = :department,
                        academic_rank = :academic_rank,
                        employment_type = :employment_type
                ";
                $params = [
                    ':employee_id' => $employee_id,
                    ':department' => $department,
                    ':academic_rank' => $academic_rank,
                    ':employment_type' => $employment_type,
                    ':id' => $id
                ];

                if ($password) {
                    $sql .= ", password = :password";
                    $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                $sql .= " WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);

                json_response(['success' => true, 'message' => 'Account updated successfully']);
            } else {
                // Add new
                $stmt = $this->db->prepare("
                    INSERT INTO employee_register 
                        (employee_id, department, academic_rank, employment_type, password, created_at)
                    VALUES (?, ?, ?, ?, ?, NOW())
                ");
                $stmt->execute([
                    $employee_id,
                    $department,
                    $academic_rank,
                    $employment_type,
                    password_hash($password, PASSWORD_DEFAULT)
                ]);

                json_response(['success' => true, 'message' => 'Employee added successfully']);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            json_response(['success' => false, 'message' => 'Server error occurred'], 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM employee_register WHERE id=?");
            $stmt->execute([$id]);
            json_response(['success' => true, 'message' => 'Account deleted successfully']);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            json_response(['success' => false, 'message' => 'Server error occurred'], 500);
        }
    }

    public function getAllDepartments()
    {
        try {
            $stmt = $this->db->query("
                SELECT dept_id, name
                FROM departments_offices
                ORDER BY name ASC
            ");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            json_response([
                'success' => true,
                'rows' => $rows
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            json_response([
                'success' => false,
                'message' => 'Failed to load departments'
            ], 500);
        }
    }

    public function getAllAcademicRanks()
    {
        try {
            $stmt = $this->db->query("
                SELECT rank_name 
                FROM academic_ranks 
                ORDER BY rank_name ASC
            ");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            json_response([
                'success' => true,
                'rows' => $rows,
                'csrf_token' => csrf_token()
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            json_response([
                'success' => false,
                'message' => 'Failed to load academic ranks',
                'csrf_token' => csrf_token()
            ], 500);
        }
    }
}
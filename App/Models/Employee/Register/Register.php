<?php
namespace App\Models\Employee\Register;

use App\Core\Model;
use PDOException;

class Register extends Model
{
    // Check if employee ID exists
    public function existsEmployee(string $employee_id): bool
    {
        try {
            $stmt = $this->pdo->prepare("SELECT 1 FROM employee_register WHERE employee_id = :employee_id LIMIT 1");
            $stmt->execute([':employee_id' => $employee_id]);
            return (bool) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('existsEmployee PDOException: ' . $e->getMessage());
            return false;
        }
    }

    // Save new employee
    public function saveEmployee(array $data): bool|string
    {
        if (empty($data['employee_id']) || empty($data['password'])) {
            return 'Employee ID or Password missing';
        }

        $employee_id = trim($data['employee_id']);
        $department = $data['department'] ?? null;
        $employment_type = $data['employment_type'] ?? null;
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO employee_register 
                        (employee_id, department, employment_type, password, created_at)
                    VALUES 
                        (:employee_id, :department, :employment_type, :password, NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':employee_id' => $employee_id,
                ':department' => $department,
                ':employment_type' => $employment_type,
                ':password' => $passwordHash,
            ]);

            return true;
        } catch (\PDOException $e) {
            error_log('saveEmployee PDOException: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
}

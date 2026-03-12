<?php
namespace App\Models\Employee\Workexp;

use App\Core\Database;
use PDO;

class Workexp
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Fetch all work experiences for an employee
    public function all(string $employeeId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM work_experience 
            WHERE employee_id = :employee_id 
            ORDER BY work_date_from DESC
        ");
        $stmt->execute(['employee_id' => $employeeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new work experience
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO work_experience 
            (employee_id, work_date_from, work_date_to, work_position, work_company, 
             work_salary, work_grade, work_status, work_govt_service, created_at)
            VALUES 
            (:employee_id, :work_date_from, :work_date_to, :work_position, :work_company, 
             :work_salary, :work_grade, :work_status, :work_govt_service, NOW())
        ");
        return $stmt->execute($data);
    }

    // Update an existing work experience
    public function update(int $id, string $employeeId, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE work_experience SET
                work_date_from    = :work_date_from,
                work_date_to      = :work_date_to,
                work_position     = :work_position,
                work_company      = :work_company,
                work_salary       = :work_salary,
                work_grade        = :work_grade,
                work_status       = :work_status,
                work_govt_service = :work_govt_service,
                updated_at        = NOW()
            WHERE id = :id AND employee_id = :employee_id
        ");
        return $stmt->execute(array_merge($data, ['id' => $id, 'employee_id' => $employeeId]));
    }

    // Delete a work experience
    public function delete(int $id, string $employeeId): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM work_experience 
            WHERE id = :id AND employee_id = :employee_id
        ");
        return $stmt->execute(['id' => $id, 'employee_id' => $employeeId]);
    }
}

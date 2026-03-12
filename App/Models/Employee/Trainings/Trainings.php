<?php
namespace App\Models\Employee\Trainings;

use App\Core\Database;
use PDO;

class Trainings
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Get trainings for employee
    public function getTrainingsByEmployee(string $employee_id): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                et.employee_training_id,
                t.training_title,
                t.type,
                t.start_date,
                t.end_date,
                et.date_completed,
                et.status,
                et.cancel_reason
            FROM employee_trainings et
            JOIN trainings t ON t.training_id = et.training_id
            WHERE et.employee_id = ?
            ORDER BY t.start_date DESC
        ");
        $stmt->execute([$employee_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Update training status
    public function updateTrainingStatus(int $employee_training_id, string $employee_id, string $status, ?string $reason = null): bool
    {
        $stmt = $this->db->prepare("
            UPDATE employee_trainings
            SET status = :status, cancel_reason = :reason
            WHERE employee_training_id = :id AND employee_id = :employee_id
        ");
        return $stmt->execute([
            ':status' => $status,
            ':reason' => $reason,
            ':id' => $employee_training_id,
            ':employee_id' => $employee_id
        ]);
    }

}

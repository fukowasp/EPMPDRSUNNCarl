<?php
namespace App\Models\Pdc;

use App\Core\Database;
use PDO;

class PdcDashboard
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getTotalEmployees(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM employee_register");
        return (int)$stmt->fetchColumn();
    }

    public function getTotalTrainings(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM trainings");
        return (int)$stmt->fetchColumn();
    }

    public function getActiveTrainings(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM trainings WHERE start_date <= NOW() AND end_date >= NOW()");
        return (int)$stmt->fetchColumn();
    }

    public function getTrainingParticipants(): array
    {
        $stmt = $this->db->query("
            SELECT t.training_title AS title, COUNT(et.employee_training_id) AS participants
            FROM trainings t
            LEFT JOIN employee_trainings et ON et.training_id = t.training_id
            GROUP BY t.training_id
            ORDER BY t.training_title ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTrainingStatusCounts(): array
    {
        $stmt = $this->db->query("
            SELECT 
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN status = 'Accepted' THEN 1 ELSE 0 END) AS accepted,
                SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) AS cancelled
            FROM employee_trainings
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getDashboardData(): array
    {
        return [
            'totalEmployees' => $this->getTotalEmployees(),
            'totalTrainings' => $this->getTotalTrainings(),
            'activeTrainings' => $this->getActiveTrainings(),
            'trainings' => $this->getTrainingParticipants(),
            'statusCounts' => $this->getTrainingStatusCounts()
        ];
    }
}

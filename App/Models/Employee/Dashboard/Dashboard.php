<?php
namespace App\Models\Employee\Dashboard;

use App\Core\Model;
use PDO;

class Dashboard extends Model
{
    // Fetch personal info
    public function getPersonalInfo($employeeId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM personal_information WHERE employee_id = :id");
        $stmt->execute(['id' => $employeeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Pending trainings
    public function getPendingTrainingInvites($employeeId)
    {
        $stmt = $this->pdo->prepare("
            SELECT et.employee_training_id, t.training_title, t.start_date
            FROM employee_trainings et
            JOIN trainings t ON t.training_id = et.training_id
            WHERE et.employee_id = :id AND et.status = 'Pending'
            ORDER BY t.start_date ASC
        ");
        $stmt->execute(['id' => $employeeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Count accepted trainings
    public function getAcceptedTrainingsCount($employeeId)
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total
            FROM employee_trainings
            WHERE employee_id = :id AND status = 'Accepted'
        ");
        $stmt->execute(['id' => $employeeId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }

    // Total Learning & Development hours
    public function getTotalLearningDevelopmentHours($employeeId)
    {
        $stmt = $this->pdo->prepare("
            SELECT SUM(ld_hours) AS total_hours, COUNT(*) AS total_trainings
            FROM learning_development_programs
            WHERE employee_id = :id
        ");
        $stmt->execute(['id' => $employeeId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'totalHours' => (int)($row['total_hours'] ?? 0),
            'totalTrainings' => (int)($row['total_trainings'] ?? 0)
        ];
    }

    // Count declined trainings
    public function getDeclinedTrainingsCount($employeeId)
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total
            FROM employee_trainings
            WHERE employee_id = :id AND status = 'Declined'
        ");
        $stmt->execute(['id' => $employeeId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }
}

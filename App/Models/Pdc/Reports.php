<?php
namespace App\Models\Pdc;

use App\Core\Database;
use PDO;

class Reports
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** All participants table */
    public function getAllParticipants(): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                et.employee_training_id,
                CONCAT(pi.first_name, ' ', pi.surname) AS employee_name,
                t.training_title,
                et.date_completed,
                t.end_date,
                et.status
            FROM employee_trainings et
            JOIN employee_register er ON er.employee_id = et.employee_id
            JOIN personal_information pi ON pi.employee_id = er.employee_id
            JOIN trainings t ON t.training_id = et.training_id
            ORDER BY et.employee_training_id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /** Participants chart: count by training */
    public function getParticipantsByTraining(): array
    {
        $stmt = $this->db->prepare("
            SELECT t.training_title, COUNT(et.employee_training_id) AS total
            FROM trainings t
            LEFT JOIN employee_trainings et ON et.training_id = t.training_id
            GROUP BY t.training_id
            ORDER BY total DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Participants status chart: count by status (Completed, Pending) */
    public function getParticipantsStatusCounts(): array
    {
        $stmt = $this->db->prepare("
            SELECT status, COUNT(*) AS total
            FROM employee_trainings
            GROUP BY status
        ");
        $stmt->execute();
        $rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Map totals to actual statuses
        $statuses = ['Accepted' => 0, 'Pending' => 0, 'Cancelled' => 0];
        foreach ($rawData as $row) {
            $status = $row['status'];
            $total  = (int) $row['total'];
            $statuses[$status] = $total;
        }

        $result = [];
        foreach ($statuses as $status => $total) {
            $result[] = ['status' => $status, 'total' => $total];
        }

        return $result;
    }
}

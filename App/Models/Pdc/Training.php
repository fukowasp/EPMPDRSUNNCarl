<?php
namespace App\Models\Pdc;

use App\Core\Database;
use PDO;

class Training
{
    protected PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    public function getTrainings(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM trainings ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTraining(array $data): bool
    {
        $stmt = $this->conn->prepare("
            INSERT INTO trainings 
                (training_title, training_description, type, category, start_date, end_date, location)
            VALUES 
                (:title, :description, :type, :category, :start, :end, :location)
        ");

        // Ensure dates are NULL if empty to prevent SQL errors
        $start = !empty($data['start_date']) ? $data['start_date'] : null;
        $end = !empty($data['end_date']) ? $data['end_date'] : null;

        return $stmt->execute([
            ':title' => $data['training_title'] ?? '',
            ':description' => $data['training_description'] ?? '',
            ':type' => $data['type'] ?? 'Training',
            ':category' => $data['category'] ?? '',
            ':start' => $start,
            ':end' => $end,
            ':location' => $data['location'] ?? ''
        ]);
    }

    public function updateTraining(array $data): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE trainings SET 
                training_title = :title,
                training_description = :description,
                type = :type,
                category = :category,
                start_date = :start,
                end_date = :end,
                location = :location
            WHERE training_id = :id
        ");

        $start = !empty($data['start_date']) ? $data['start_date'] : null;
        $end = !empty($data['end_date']) ? $data['end_date'] : null;

        return $stmt->execute([
            ':title' => $data['training_title'] ?? '',
            ':description' => $data['training_description'] ?? '',
            ':type' => $data['type'] ?? 'Training',
            ':category' => $data['category'] ?? '',
            ':start' => $start,
            ':end' => $end,
            ':location' => $data['location'] ?? '',
            ':id' => $data['training_id'] ?? 0
        ]);
    }

    public function deleteTraining(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM trainings WHERE training_id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getTrainingsData(): array
    {
        $stmt = $this->conn->prepare("SELECT training_id, training_title, category FROM trainings ORDER BY training_title ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php
namespace App\Models\Employee\Civilser;

use App\Core\Database;
use PDO;
use PDOException;

class Civilser
{
    protected $table = 'civil_service_eligibility';
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Save or Update eligibilities for an employee
     * If 'id' exists, update; else insert new.
     */
    public function saveOrUpdate(string $employee_id, array $eligibilities): bool
    {
        try {
            $this->db->beginTransaction();

            foreach ($eligibilities as $item) {
                if (empty($item['type'])) continue;

                // Determine if this is an update or insert
                if (!empty($item['id'])) {
                    // Update
                    $sql = "UPDATE {$this->table} SET
                            career_service = :career_service,
                            rating = :rating,
                            date_of_examination_conferment = :date_of_examination_conferment,
                            place_of_examination_conferment = :place_of_examination_conferment,
                            proof_of_certification = :proof_of_certification,
                            updated_at = NOW()
                            WHERE id = :id AND employee_id = :employee_id";

                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        ':career_service' => $item['type'],
                        ':rating' => $item['rating'] ?? null,
                        ':date_of_examination_conferment' => $item['date'] ?? null,
                        ':place_of_examination_conferment' => $item['place'] ?? null,
                        ':proof_of_certification' => $item['proof'] ?? $item['existing_proof'] ?? null,
                        ':id' => $item['id'],
                        ':employee_id' => $employee_id
                    ]);
                } else {
                    // Insert
                    $sql = "INSERT INTO {$this->table} 
                            (employee_id, career_service, rating, date_of_examination_conferment, place_of_examination_conferment, proof_of_certification, created_at)
                            VALUES (:employee_id, :career_service, :rating, :date_of_examination_conferment, :place_of_examination_conferment, :proof_of_certification, NOW())";

                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        ':employee_id' => $employee_id,
                        ':career_service' => $item['type'],
                        ':rating' => $item['rating'] ?? null,
                        ':date_of_examination_conferment' => $item['date'] ?? null,
                        ':place_of_examination_conferment' => $item['place'] ?? null,
                        ':proof_of_certification' => $item['proof'] ?? null
                    ]);
                }
            }

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Civilser SaveOrUpdate Error: " . $e->getMessage());
            return false;
        }
    }

    // Get all eligibilities for an employee
    public function getByEmployee(string $employee_id): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE employee_id = :employee_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':employee_id' => $employee_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete an eligibility by ID
    public function delete(int $id, string $employee_id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id AND employee_id = :employee_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id, ':employee_id' => $employee_id]);
    }
}

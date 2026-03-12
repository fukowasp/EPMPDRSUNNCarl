<?php
namespace App\Models\Admin;

use App\Core\Database;
use PDO;

class GraduateStudies
{
    protected PDO $db;
    protected string $table = 'graduate_studies';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $sql = "
            SELECT 
                gs.id,
                gs.employee_id,
                pi.first_name,
                pi.surname,
                gs.institution_name,
                gs.graduate_course,
                gs.year_graduated,
                gs.units_earned,
                gs.specialization,
                gs.honor_received,
                gs.certification_file
            FROM {$this->table} gs
            LEFT JOIN personal_information pi ON gs.employee_id = pi.employee_id
            ORDER BY gs.id DESC
        ";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} SET
            institution_name = :institution_name,
            graduate_course = :graduate_course,
            year_graduated = :year_graduated,
            units_earned = :units_earned,
            specialization = :specialization,
            honor_received = :honor_received,
            certification_file = :certification_file
            WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

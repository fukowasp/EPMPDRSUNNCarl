<?php
namespace App\Models\Employee\Eduback;

use App\Core\Database;
use PDO;

class GraduateStudies
{
    private PDO $db;
    private string $table = 'graduate_studies';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllByEmpId(string $employee_id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE employee_id = :eid ORDER BY year_graduated DESC");
        $stmt->execute([':eid'=>$employee_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function findById(int $id, string $employee_id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=:id AND employee_id=:eid LIMIT 1");
        $stmt->execute([':id'=>$id, ':eid'=>$employee_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function saveRecord(string $employee_id, ?int $id, string $institution, string $course, ?string $year, ?string $units, ?string $specialization, ?string $honor, ?string $certFile)
    {
        if ($id) {
            $sql = "UPDATE {$this->table} SET institution_name=:institution, graduate_course=:course, year_graduated=:year, units_earned=:units, specialization=:spec, honor_received=:honor" . ($certFile ? ", certification_file=:cert" : "") . " WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            $params = [':institution'=>$institution, ':course'=>$course, ':year'=>$year, ':units'=>$units, ':spec'=>$specialization, ':honor'=>$honor, ':id'=>$id];
            if ($certFile) $params[':cert'] = $certFile;
            return $stmt->execute($params);
        } else {
            $sql = "INSERT INTO {$this->table} (employee_id, institution_name, graduate_course, year_graduated, units_earned, specialization, honor_received, certification_file) VALUES (:eid, :institution, :course, :year, :units, :spec, :honor, :cert)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':eid'=>$employee_id, ':institution'=>$institution, ':course'=>$course, ':year'=>$year, ':units'=>$units, ':spec'=>$specialization, ':honor'=>$honor, ':cert'=>$certFile]);
        }
    }

    public function deleteById(int $id, string $employee_id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id=:id AND employee_id=:eid");
        return $stmt->execute([':id'=>$id, ':eid'=>$employee_id]);
    }
}

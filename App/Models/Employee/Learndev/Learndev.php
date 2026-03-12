<?php
namespace App\Models\Employee\Learndev;

use App\Core\Database;
use PDO;

class Learndev
{
    protected PDO $pdo;
    protected string $table = 'learning_development_programs';

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
            (employee_id, ld_title, ld_date_from, ld_date_to, ld_hours, ld_type, ld_sponsor, ld_certification)
            VALUES (:employee_id, :ld_title, :ld_date_from, :ld_date_to, :ld_hours, :ld_type, :ld_sponsor, :ld_certification)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function allByEmployee(string $employee_id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE employee_id=:id ORDER BY ld_date_from DESC");
        $stmt->execute([':id'=>$employee_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id, string $employee_id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id=:id AND employee_id=:employee_id");
        $stmt->execute([':id'=>$id, ':employee_id'=>$employee_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function updateProgram(int $id, string $employee_id, array $data): bool
    {
        $sql = "UPDATE {$this->table} SET
            ld_title = :ld_title,
            ld_date_from = :ld_date_from,
            ld_date_to = :ld_date_to,
            ld_hours = :ld_hours,
            ld_type = :ld_type,
            ld_sponsor = :ld_sponsor,
            ld_certification = :ld_certification
            WHERE id = :id AND employee_id = :employee_id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([...$data, ':id'=>$id, ':employee_id'=>$employee_id]);
    }

    public function deleteProgram(int $id, string $employee_id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id=:id AND employee_id=:employee_id");
        return $stmt->execute([':id'=>$id, ':employee_id'=>$employee_id]);
    }
}

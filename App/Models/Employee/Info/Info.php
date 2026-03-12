<?php
namespace App\Models\Employee\Info;

use App\Core\Model;
use PDO;

class Info extends Model
{
    protected string $table = 'personal_information';

    // Save or update
    public function save(array $data): bool
    {
        if (empty($data['employee_id'])) return false;

        $employeeId = $data['employee_id'];

        if ($this->exists($employeeId)) {
            $columns = array_keys($data);
            $updateFields = [];
            foreach ($columns as $col) {
                if ($col !== 'employee_id') $updateFields[] = "$col = :$col";
            }
            $sql = "UPDATE {$this->table} SET " . implode(', ', $updateFields) . " WHERE employee_id = :employee_id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } else {
            $columns = array_keys($data);
            $placeholders = ':' . implode(', :', $columns);
            $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        }
    }

    public function getByEmployeeId(string $employeeId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE employee_id = :employee_id LIMIT 1");
        $stmt->execute(['employee_id' => $employeeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function exists(string $employeeId): bool
    {
        $stmt = $this->pdo->prepare("SELECT 1 FROM {$this->table} WHERE employee_id = :employee_id LIMIT 1");
        $stmt->execute(['employee_id' => $employeeId]);
        return (bool) $stmt->fetchColumn();
    }

    
}

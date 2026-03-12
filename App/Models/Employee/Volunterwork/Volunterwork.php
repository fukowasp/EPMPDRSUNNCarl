<?php
namespace App\Models\Employee\Volunterwork;

use App\Core\Database;
use PDO;

class Volunterwork
{
    protected PDO $db;
    protected string $table = 'voluntarywork';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getByEmployee(string $employeeId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE employee_id = ? ORDER BY id DESC");
        $stmt->execute([$employeeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id, string $employeeId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ? AND employee_id = ?");
        $stmt->execute([$id, $employeeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} 
             (organization_name, position_role, organization_address, start_date, end_date, number_of_hours, membership_id_url, employee_id)
             VALUES (:organization_name, :position_role, :organization_address, :start_date, :end_date, :number_of_hours, :membership_id_url, :employee_id)"
        );
        return $stmt->execute($data);
    }

    public function updateById(int $id, string $employeeId, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET 
             organization_name=:organization_name, 
             position_role=:position_role, 
             organization_address=:organization_address, 
             start_date=:start_date, 
             end_date=:end_date, 
             number_of_hours=:number_of_hours, 
             membership_id_url=:membership_id_url 
             WHERE id=:id AND employee_id=:employee_id"
        );
        $data['id'] = $id;
        $data['employee_id'] = $employeeId;
        return $stmt->execute($data);
    }

    public function deleteById(int $id, string $employeeId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id=? AND employee_id=?");
        return $stmt->execute([$id, $employeeId]);
    }


    public function save(string $employeeId, array $works): bool
    {
        $allSuccess = true;

        foreach ($works as $work) {
            $data = [
                'organization_name'   => $work['organization_name'] ?? '',
                'position_role'       => $work['position_role'] ?? '',
                'organization_address'=> $work['organization_address'] ?? '',
                'start_date'          => $work['start_date'] ?? null,
                'end_date'            => $work['end_date'] ?? null,
                'number_of_hours'     => $work['number_of_hours'] ?? 0,
                'membership_id_url'   => $work['membership_id_url'] ?? '',
                'employee_id'         => $employeeId
            ];

            $success = !empty($work['id'])
                ? $this->updateById((int)$work['id'], $employeeId, $data)
                : $this->create($data);

            if (!$success) $allSuccess = false;
        }

        return $allSuccess;
    }
}

<?php
namespace App\Models\Employee\C4sections;

use App\Core\Database;
use PDO;
use PDOException;


class C4sections
{
    protected $table = 'c4_sections';
    protected PDO $db;

    public function __construct()
    {
        // Get the PDO instance from Database singleton
        $this->db = Database::getInstance();
    }

    public function getByEmployeeId(string $employee_id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE employee_id = ?");
        $stmt->execute([$employee_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function save(array $data): bool
    {
        try {
            $existing = $this->getByEmployeeId($data['employee_id']);

            if ($existing) {
                $fields = [];
                $values = [];
                foreach ($data as $key => $val) {
                    if ($key !== 'employee_id') {
                        $fields[] = "$key = ?";
                        $values[] = $val;
                    }
                }
                $values[] = $data['employee_id'];
                $sql = "UPDATE {$this->table} SET ".implode(', ', $fields)." WHERE employee_id = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute($values);
            } else {
                $cols = implode(',', array_keys($data));
                $placeholders = implode(',', array_fill(0, count($data), '?'));
                $stmt = $this->db->prepare("INSERT INTO {$this->table} ($cols) VALUES ($placeholders)");
                return $stmt->execute(array_values($data));
            }
        } catch (PDOException $e) {
            error_log("C4sections save error: " . $e->getMessage());
            return false;
        }
    }
}

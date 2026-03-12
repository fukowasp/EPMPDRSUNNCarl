<?php
namespace App\Models\Employee\Famback;

use App\Core\Database;
use PDO;

class Famback
{
    protected $db;
    protected $table = "family_background";

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Get family background for an employee
    public function getByEmployeeId(string $employeeId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE employee_id = :employee_id LIMIT 1");
        $stmt->execute([":employee_id" => $employeeId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        // Get children
        $stmt = $this->db->prepare("SELECT child_name, child_birthdate FROM family_children WHERE employee_id = :eid ORDER BY child_birthdate ASC");
        $stmt->execute([":eid" => $employeeId]);
        $data['children'] = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        return $data;
    }

    // Save or update family background and children
    public function save(array $data): bool
    {
        $allowed = [
            "employee_id",
            "spouse_surname","spouse_first_name","spouse_middle_name","spouse_name_extension",
            "spouse_occupation","spouse_employer_name","spouse_business_address","spouse_telephone_no",
            "father_surname","father_first_name","father_middle_name","father_name_extension",
            "mother_maiden_name","mother_surname","mother_first_name","mother_middle_name"
        ];

        $filtered = [];
        foreach ($allowed as $f) {
            $filtered[$f] = isset($data[$f]) ? trim($data[$f]) : null;
        }

        try {
            // Start transaction
            $this->db->beginTransaction();

            // Upsert main family_background
            $sql = "INSERT INTO family_background (
                        employee_id, spouse_surname, spouse_first_name, spouse_middle_name, spouse_name_extension,
                        spouse_occupation, spouse_employer_name, spouse_business_address, spouse_telephone_no,
                        father_surname, father_first_name, father_middle_name, father_name_extension,
                        mother_maiden_name, mother_surname, mother_first_name, mother_middle_name, created_at
                    ) VALUES (
                        :employee_id, :spouse_surname, :spouse_first_name, :spouse_middle_name, :spouse_name_extension,
                        :spouse_occupation, :spouse_employer_name, :spouse_business_address, :spouse_telephone_no,
                        :father_surname, :father_first_name, :father_middle_name, :father_name_extension,
                        :mother_maiden_name, :mother_surname, :mother_first_name, :mother_middle_name, NOW()
                    )
                    ON DUPLICATE KEY UPDATE
                        spouse_surname=VALUES(spouse_surname),
                        spouse_first_name=VALUES(spouse_first_name),
                        spouse_middle_name=VALUES(spouse_middle_name),
                        spouse_name_extension=VALUES(spouse_name_extension),
                        spouse_occupation=VALUES(spouse_occupation),
                        spouse_employer_name=VALUES(spouse_employer_name),
                        spouse_business_address=VALUES(spouse_business_address),
                        spouse_telephone_no=VALUES(spouse_telephone_no),
                        father_surname=VALUES(father_surname),
                        father_first_name=VALUES(father_first_name),
                        father_middle_name=VALUES(father_middle_name),
                        father_name_extension=VALUES(father_name_extension),
                        mother_maiden_name=VALUES(mother_maiden_name),
                        mother_surname=VALUES(mother_surname),
                        mother_first_name=VALUES(mother_first_name),
                        mother_middle_name=VALUES(mother_middle_name)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($filtered);

            // Children: delete + batch insert
            if (!empty($data['children']) && is_array($data['children'])) {
                $del = $this->db->prepare("DELETE FROM family_children WHERE employee_id = :eid");
                $del->execute([":eid" => $data['employee_id']]);

                $values = [];
                $params = [];
                $i = 0;
                foreach ($data['children'] as $c) {
                    if (!empty($c['child_name']) && !empty($c['child_birthdate'])) {
                        $values[] = "(:eid{$i}, :cname{$i}, :cdob{$i})";
                        $params[":eid{$i}"] = $data['employee_id'];
                        $params[":cname{$i}"] = trim($c['child_name']);
                        $params[":cdob{$i}"] = $c['child_birthdate'];
                        $i++;
                    }
                }

                if ($values) {
                    $insSql = "INSERT INTO family_children (employee_id, child_name, child_birthdate) VALUES " . implode(",", $values);
                    $ins = $this->db->prepare($insSql);
                    $ins->execute($params);
                }
            }

            // Commit transaction
            $this->db->commit();
            return true;

        } catch (\Exception $e) {
            // Rollback on error
            $this->db->rollBack();
            error_log("Famback Save Error: " . $e->getMessage());
            return false;
        }
    }

}

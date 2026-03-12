<?php
declare(strict_types=1);
namespace App\Models\Pdc;

use PDO;
use PDOException;
use App\Core\Database;

class EmployeeList
{
    protected PDO $conn;

    public function __construct(?PDO $pdo = null)
    {
        $this->conn = $pdo ?? Database::getInstance();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    /** Fetch all employees with optional search */
    public function getAll(int $limit = 200, int $offset = 0, ?string $search = null): array
    {
        try {
            $params = [];
            $where = '';

            if ($search) {
                $term = '%' . strtolower(trim($search)) . '%';
                $where = " WHERE 
                    LOWER(CONCAT_WS(' ', COALESCE(p.first_name,''), COALESCE(p.surname,''))) LIKE :term
                    OR LOWER(e.department) LIKE :term
                    OR LOWER(e.employee_id) LIKE :term
                    OR LOWER(p.email_address) LIKE :term
                ";
                $params[':term'] = $term;
            }

            // COUNT
            $countQuery = "
                SELECT COUNT(*)
                FROM employee_register e
                LEFT JOIN personal_information p ON e.employee_id = p.employee_id
                $where
            ";

            $stmtCount = $this->conn->prepare($countQuery);
            foreach ($params as $k => $v) $stmtCount->bindValue($k, $v);
            $stmtCount->execute();
            $total = (int)$stmtCount->fetchColumn();

            // DATA
            $sql = "
                SELECT 
                    e.employee_id,
                    p.first_name,
                    p.surname,
                    e.department,
                    e.employment_type,
                    p.mobile_no,
                    p.email_address
                FROM employee_register e
                LEFT JOIN personal_information p ON e.employee_id = p.employee_id
                $where
                ORDER BY p.surname ASC, p.first_name ASC
                LIMIT :limit OFFSET :offset
            ";

            $stmt = $this->conn->prepare($sql);

            foreach ($params as $k => $v) $stmt->bindValue($k, $v, PDO::PARAM_STR);
            $stmt->bindValue(':limit', max(1, min($limit, 300)), PDO::PARAM_INT);
            $stmt->bindValue(':offset', max(0, $offset), PDO::PARAM_INT);

            $stmt->execute();

            return [
                'rows' => $stmt->fetchAll(PDO::FETCH_ASSOC),
                'total' => $total
            ];

        } catch (PDOException $e) {
            error_log('[PDC EmployeeList::getAll] ' . $e->getMessage());
            return ['rows' => [], 'total' => 0];
        }
    }

    /** Fetch full PDS for a single employee */
    public function getEmployeePDS(string $employee_id): array
    {
        try {
            // Personal info
            $stmt = $this->conn->prepare("
                SELECT p.*, e.department, e.employment_type
                FROM personal_information p
                JOIN employee_register e ON p.employee_id = e.employee_id
                WHERE p.employee_id = ?
            ");
            $stmt->execute([$employee_id]);
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$employee) return [];

            // Family info
            $stmt = $this->conn->prepare("
                SELECT 
                    CONCAT_WS(' ', spouse_first_name, spouse_middle_name, spouse_surname, spouse_name_extension) AS spouse_full_name,
                    spouse_occupation,
                    spouse_employer_name,
                    spouse_business_address,
                    spouse_telephone_no,
                    CONCAT_WS(' ', father_first_name, father_middle_name, father_surname, father_name_extension) AS father_full_name,
                    CONCAT_WS(' ', mother_first_name, mother_middle_name, mother_surname) AS mother_full_name,
                    mother_maiden_name
                FROM family_background 
                WHERE employee_id = ?
            ");
            $stmt->execute([$employee_id]);
            $family = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

            // Education
            $stmt = $this->conn->prepare("SELECT * FROM educational_background WHERE employee_id=?");
            $stmt->execute([$employee_id]);
            $education = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

            // Graduate Studies
            $stmt = $this->conn->prepare("
                SELECT institution_name, graduate_course, year_graduated,
                    units_earned, specialization, honor_received, certification_file
                FROM graduate_studies
                WHERE employee_id = ?
                ORDER BY year_graduated DESC
            ");
            $stmt->execute([$employee_id]);
            $graduate_studies = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Civil service eligibility
            $stmt = $this->conn->prepare("SELECT * FROM civil_service_eligibility WHERE employee_id=? ORDER BY date_of_examination_conferment DESC");
            $stmt->execute([$employee_id]);
            $civil_service = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Work experience
            $stmt = $this->conn->prepare("SELECT * FROM work_experience WHERE employee_id=? ORDER BY work_date_from DESC");
            $stmt->execute([$employee_id]);
            $work_experience = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Voluntary work
            $stmt = $this->conn->prepare("SELECT * FROM voluntarywork WHERE employee_id=? ORDER BY start_date DESC");
            $stmt->execute([$employee_id]);
            $voluntarywork = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Learning & development programs
            $stmt = $this->conn->prepare("SELECT * FROM learning_development_programs WHERE employee_id=? ORDER BY ld_date_from DESC");
            $stmt->execute([$employee_id]);
            $learning_development = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $this->conn->prepare("SELECT * FROM c4_sections WHERE employee_id = ?");
            $stmt->execute([$employee_id]);
            $c4_sections = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

            /* ------------------------------------------------------------------
            🔹 NEW TABLES INSERTED HERE
            ------------------------------------------------------------------ */

            // OTHER INFORMATION — SKILLS / HOBBIES
            $stmt = $this->conn->prepare("
                SELECT skill_hobby, created_at
                FROM other_information_skills
                WHERE employee_id = ?
                ORDER BY id DESC
            ");
            $stmt->execute([$employee_id]);
            $other_skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // OTHER INFORMATION — RECOGNITION
            $stmt = $this->conn->prepare("
                SELECT recognition, created_at
                FROM other_information_recognition
                WHERE employee_id = ?
                ORDER BY id DESC
            ");
            $stmt->execute([$employee_id]);
            $other_recognition = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // OTHER INFORMATION — MEMBERSHIP
            $stmt = $this->conn->prepare("
                SELECT membership, proof_membership, created_at
                FROM other_information_membership
                WHERE employee_id = ?
                ORDER BY id DESC
            ");
            $stmt->execute([$employee_id]);
            $other_membership = $stmt->fetchAll(PDO::FETCH_ASSOC);
            /* ------------------------------------------------------------------ */
            return [
                'employee' => $employee,
                'family' => $family,
                'education' => $education,
                'graduate_studies' => $graduate_studies,
                'civil_service' => $civil_service,
                'work_experience' => $work_experience,
                'voluntarywork' => $voluntarywork,
                'learning_development' => $learning_development,

                // NEW KEYS
                'other_skills' => $other_skills,
                'other_recognition' => $other_recognition,
                'other_membership' => $other_membership,

                'c4_sections' => $c4_sections
                
            ];

        } catch (PDOException $e) {
            error_log('[PDC EmployeeList::getEmployeePDS] ' . $e->getMessage());
            return [];
        }
    }

}

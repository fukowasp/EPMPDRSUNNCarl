<?php
namespace App\Models\Employee\Eduback;

use App\Core\Database;
use PDO;
use PDOException;

class Eduback 
{
    protected PDO $db;
    protected string $educTable = "educational_background";

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** Get educational background only */
    public function getByEmployee(string $employeeId): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->educTable} WHERE employee_id = :id LIMIT 1");
            $stmt->execute([":id" => $employeeId]);
            $educBackground = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

            return [
                "educational_background" => $educBackground
            ];
        } catch (PDOException $e) {
            throw new \Exception("Failed to fetch education data");
        }
    }

    /** Save educational background only */
    public function save(string $employeeId, array $educBackground): bool
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO {$this->educTable} 
                (employee_id, elementary_school_name, elementary_year_graduated, elementary_honor,
                 secondary_school_name, secondary_year_graduated, secondary_honor,
                 seniorhigh_school_name, seniorhigh_year_graduated, seniorhigh_honor,
                 vocational_course, vocational_year_completed, vocational_honor,
                 college_course, college_year_graduated, college_units_earned, college_honor)
                VALUES (:employee_id, :elementary_school_name, :elementary_year_graduated, :elementary_honor,
                        :secondary_school_name, :secondary_year_graduated, :secondary_honor,
                        :seniorhigh_school_name, :seniorhigh_year_graduated, :seniorhigh_honor,
                        :vocational_course, :vocational_year_completed, :vocational_honor,
                        :college_course, :college_year_graduated, :college_units_earned, :college_honor)
                ON DUPLICATE KEY UPDATE
                    elementary_school_name = VALUES(elementary_school_name),
                    elementary_year_graduated = VALUES(elementary_year_graduated),
                    elementary_honor = VALUES(elementary_honor),
                    secondary_school_name = VALUES(secondary_school_name),
                    secondary_year_graduated = VALUES(secondary_year_graduated),
                    secondary_honor = VALUES(secondary_honor),
                    seniorhigh_school_name = VALUES(seniorhigh_school_name),
                    seniorhigh_year_graduated = VALUES(seniorhigh_year_graduated),
                    seniorhigh_honor = VALUES(seniorhigh_honor),
                    vocational_course = VALUES(vocational_course),
                    vocational_year_completed = VALUES(vocational_year_completed),
                    vocational_honor = VALUES(vocational_honor),
                    college_course = VALUES(college_course),
                    college_year_graduated = VALUES(college_year_graduated),
                    college_units_earned = VALUES(college_units_earned),
                    college_honor = VALUES(college_honor)
            ");

            $stmt->execute(array_merge([':employee_id'=>$employeeId], $educBackground));
            return true;
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

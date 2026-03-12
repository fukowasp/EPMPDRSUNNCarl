<?php
namespace App\Models\Admin;

use App\Core\Database;
use PDO;

class Report
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getGraduateStudies(): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                gs.id,
                gs.employee_id,
                pi.first_name,
                pi.surname,
                gs.institution_name,
                gs.graduate_course
            FROM graduate_studies gs
            JOIN personal_information pi ON pi.employee_id = gs.employee_id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getGraduateStudiesChartData(): array
    {
        $stmt = $this->db->prepare("
            SELECT graduate_course, COUNT(*) as total
            FROM graduate_studies
            GROUP BY graduate_course
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

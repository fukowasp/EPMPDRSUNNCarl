<?php
declare(strict_types=1);

namespace App\Models\Admin;

use PDO;
use PDOException;
use App\Core\Database;

class AdminDashboard
{
    protected PDO $conn;

    public function __construct(?PDO $pdo = null)
    {
        $this->conn = $pdo ?? Database::getInstance();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /** Count total employees */
    public function getTotalEmployees(): int
    {
        try {
            $stmt = $this->conn->query("SELECT COUNT(*) FROM employee_register");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('[Dashboard::getTotalEmployees] ' . $e->getMessage());
            return 0;
        }
    }

    /** Graduate Studies Distribution (real join) */
    public function getGraduateStudyDistribution(): array
    {
        try {
            $stmt = $this->conn->query("
                SELECT 
                    g.course_name AS program, 
                    COUNT(gs.id) AS total
                FROM grad_tables g
                LEFT JOIN graduate_studies gs 
                    ON g.course_name COLLATE utf8mb4_general_ci = gs.graduate_course COLLATE utf8mb4_general_ci
                GROUP BY g.course_name
                ORDER BY g.course_name ASC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('[Dashboard::getGraduateStudyDistribution] ' . $e->getMessage());
            return [];
        }
    }

    /** Count total Permanent employees */
    public function getTotalPermanentEmployees(): int
    {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM employee_register WHERE employment_type = :type");
            $stmt->execute(['type' => 'Permanent']);
            return (int) $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log('[Dashboard::getTotalPermanentEmployees] ' . $e->getMessage());
            return 0;
        }
    }

    /** Count total Non-Permanent employees */
    public function getTotalNonPermanentEmployees(): int
    {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM employee_register WHERE employment_type = :type");
            $stmt->execute(['type' => 'Non-Permanent']);
            return (int) $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log('[Dashboard::getTotalNonPermanentEmployees] ' . $e->getMessage());
            return 0;
        }
    }

}

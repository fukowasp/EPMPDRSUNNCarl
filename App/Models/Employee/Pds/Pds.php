<?php

namespace App\Models\Employee\Pds;

use App\Core\Database;
use PDO;
class Pds
{
    
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function getAllPdsData($employeeId): array
    {
        return [
            'personal'      => $this->getPersonal($employeeId),
            'education'     => $this->getEducation($employeeId),
            'family'        => $this->getFamily($employeeId),
            'professional'  => $this->getProfessional($employeeId),
            'other'         => $this->getOtherInformation($employeeId),
            'register'      => $this->getEmployeeRegister($employeeId)
        ];
    }

    /* ---------------------------------------
       PERSONAL INFORMATION
    --------------------------------------- */

    private function getPersonal($employeeId): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM personal_information
            WHERE employee_id = ?
            LIMIT 1
        ");

        $stmt->execute([$employeeId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    /* ---------------------------------------
       EDUCATION + GRADUATE STUDIES
    --------------------------------------- */

    private function getEducation($employeeId): array
    {
        $education = $this->pdo->prepare("
            SELECT *
            FROM educational_background
            WHERE employee_id = ?
            LIMIT 1
        ");

        $education->execute([$employeeId]);

        $graduate = $this->pdo->prepare("
            SELECT *
            FROM graduate_studies
            WHERE employee_id = ?
            ORDER BY id DESC
        ");

        $graduate->execute([$employeeId]);

        return [
            'education' => $education->fetch(\PDO::FETCH_ASSOC),
            'graduate'  => $graduate->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    /* ---------------------------------------
       FAMILY INFORMATION
    --------------------------------------- */

    private function getFamily($employeeId): array
    {
        $family = $this->pdo->prepare("
            SELECT *
            FROM family_background
            WHERE employee_id = ?
            LIMIT 1
        ");

        $family->execute([$employeeId]);

        $children = $this->pdo->prepare("
            SELECT *
            FROM family_children
            WHERE employee_id = ?
            ORDER BY child_birthdate ASC
        ");

        $children->execute([$employeeId]);

        return [
            'family'   => $family->fetch(\PDO::FETCH_ASSOC),
            'children' => $children->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    /* ---------------------------------------
       PROFESSIONAL DATA
    --------------------------------------- */

    private function getProfessional($employeeId): array
    {
        $eligibility = $this->pdo->prepare("
            SELECT *
            FROM civil_service_eligibility
            WHERE employee_id = ?
            ORDER BY date_of_examination_conferment DESC
        ");

        $eligibility->execute([$employeeId]);

        $work = $this->pdo->prepare("
            SELECT *
            FROM work_experience
            WHERE employee_id = ?
            ORDER BY work_date_from DESC
        ");

        $work->execute([$employeeId]);

        $voluntary = $this->pdo->prepare("
            SELECT *
            FROM voluntarywork
            WHERE employee_id = ?
            ORDER BY start_date DESC
        ");

        $voluntary->execute([$employeeId]);

        $ld = $this->pdo->prepare("
            SELECT *
            FROM learning_development_programs
            WHERE employee_id = ?
            ORDER BY ld_date_from DESC
        ");

        $ld->execute([$employeeId]);

        return [
            'eligibility' => $eligibility->fetchAll(\PDO::FETCH_ASSOC),
            'work'        => $work->fetchAll(\PDO::FETCH_ASSOC),
            'voluntary'   => $voluntary->fetchAll(\PDO::FETCH_ASSOC),
            'ld'          => $ld->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    /* ---------------------------------------
       OTHER INFORMATION
    --------------------------------------- */

    private function getOtherInformation($employeeId): array
    {
        $skills = $this->pdo->prepare("
            SELECT *
            FROM other_information_skills
            WHERE employee_id = ?
        ");

        $skills->execute([$employeeId]);

        $recognition = $this->pdo->prepare("
            SELECT *
            FROM other_information_recognition
            WHERE employee_id = ?
        ");

        $recognition->execute([$employeeId]);

        $membership = $this->pdo->prepare("
            SELECT *
            FROM other_information_membership
            WHERE employee_id = ?
        ");

        $membership->execute([$employeeId]);

        $c4 = $this->pdo->prepare("
            SELECT *
            FROM c4_sections
            WHERE employee_id = ?
            LIMIT 1
        ");

        $c4->execute([$employeeId]);

        return [
            'skills'       => $skills->fetchAll(\PDO::FETCH_ASSOC),
            'recognition'  => $recognition->fetchAll(\PDO::FETCH_ASSOC),
            'membership'   => $membership->fetchAll(\PDO::FETCH_ASSOC),
            'c4'           => $c4->fetch(\PDO::FETCH_ASSOC)
        ];
    }

    /* ---------------------------------------
       EMPLOYEE REGISTER
    --------------------------------------- */

    private function getEmployeeRegister($employeeId): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT id, employee_id, department, academic_rank, employment_type, created_at
            FROM employee_register
            WHERE employee_id = ?
            LIMIT 1
        ");

        $stmt->execute([$employeeId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
}
<?php
namespace App\Models\Employee\Otherinfo;

use App\Core\Database;
use PDO;

class Otherinfo
{
    protected $db;
    protected $skillsTable = 'other_information_skills';
    protected $recognitionTable = 'other_information_recognition';
    protected $membershipTable = 'other_information_membership';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // ================== READ ==================

    public function getAllByEmployee($employee_id)
    {
        $skillsStmt = $this->db->prepare("SELECT * FROM {$this->skillsTable} WHERE employee_id = :employee_id");
        $skillsStmt->execute(['employee_id' => $employee_id]);
        $skills = $skillsStmt->fetchAll(PDO::FETCH_ASSOC);

        $recogStmt = $this->db->prepare("SELECT * FROM {$this->recognitionTable} WHERE employee_id = :employee_id");
        $recogStmt->execute(['employee_id' => $employee_id]);
        $recognitions = $recogStmt->fetchAll(PDO::FETCH_ASSOC);

        $memStmt = $this->db->prepare("SELECT * FROM {$this->membershipTable} WHERE employee_id = :employee_id");
        $memStmt->execute(['employee_id' => $employee_id]);
        $memberships = $memStmt->fetchAll(PDO::FETCH_ASSOC);

        $maxRows = max(count($skills), count($recognitions), count($memberships));
        $result = [];

        for ($i = 0; $i < $maxRows; $i++) {
            $result[] = [
                'id' => $skills[$i]['id'] ?? $recognitions[$i]['id'] ?? $memberships[$i]['id'] ?? null,
                'skills_hobbies' => $skills[$i]['skill_hobby'] ?? '',
                'distinctions' => $recognitions[$i]['recognition'] ?? '',
                'membership' => $memberships[$i]['membership'] ?? '',
                'proof_membership' => $memberships[$i]['proof_membership'] ?? '' // <- add this
            ];
        }
        return $result;
    }

    public function getSkillById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->skillsTable} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRecognitionById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->recognitionTable} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMembershipById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->membershipTable} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================== CREATE ==================

    public function insertSkill($employee_id, $skill)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->skillsTable} (employee_id, skill_hobby) VALUES (:employee_id, :skill)");
        return $stmt->execute(['employee_id' => $employee_id, 'skill' => $skill]);
    }

    public function insertRecognition($employee_id, $recognition)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->recognitionTable} (employee_id, recognition) VALUES (:employee_id, :recognition)");
        return $stmt->execute(['employee_id' => $employee_id, 'recognition' => $recognition]);
    }

    public function insertMembership($employee_id, $membership, $proof = null)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->membershipTable} (employee_id, membership, proof_membership) VALUES (:employee_id, :membership, :proof)");
        return $stmt->execute([
            'employee_id' => $employee_id,
            'membership' => $membership,
            'proof' => $proof
        ]);
    }

    // ================== UPDATE ==================

    public function updateSkill($id, $skill)
    {
        $stmt = $this->db->prepare("UPDATE {$this->skillsTable} SET skill_hobby = :skill WHERE id = :id");
        return $stmt->execute(['id' => $id, 'skill' => $skill]);
    }

    public function updateRecognition($id, $recognition)
    {
        $stmt = $this->db->prepare("UPDATE {$this->recognitionTable} SET recognition = :recognition WHERE id = :id");
        return $stmt->execute(['id' => $id, 'recognition' => $recognition]);
    }

    public function updateMembership($id, $membership, $proof = null)
    {
        $stmt = $this->db->prepare("UPDATE {$this->membershipTable} SET membership = :membership, proof_membership = :proof WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'membership' => $membership,
            'proof' => $proof
        ]);
    }

    // ================== DELETE ==================

    public function deleteSkill($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->skillsTable} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteRecognition($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->recognitionTable} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteMembership($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->membershipTable} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

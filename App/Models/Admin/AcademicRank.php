<?php
namespace App\Models\Admin;

use App\Core\Database;
use PDO;

class AcademicRank
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM academic_ranks ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        json_response(['data' => $rows]); // <-- use json_response
    }

    public function add(string $name)
    {
        try {
            $check = $this->db->prepare("SELECT id FROM academic_ranks WHERE rank_name=?");
            $check->execute([$name]);
            if ($check->fetch()) {
                json_response(['success'=>false,'message'=>'Rank already exists'], 400);
            }

            $stmt = $this->db->prepare("INSERT INTO academic_ranks (rank_name) VALUES (?)");
            $stmt->execute([$name]);

            json_response(['success'=>true]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            json_response(['success'=>false,'message'=>'Server error occurred'], 500);
        }
    }

    public function update(int $id, string $name)
    {
        try {
            $stmt = $this->db->prepare("UPDATE academic_ranks SET rank_name=? WHERE id=?");
            $stmt->execute([$name, $id]);
            json_response(['success'=>true]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            json_response(['success'=>false,'message'=>'Server error occurred'], 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM academic_ranks WHERE id=?");
            $stmt->execute([$id]);
            json_response(['success'=>true]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            json_response(['success'=>false,'message'=>'Server error occurred'], 500);
        }
    }
}

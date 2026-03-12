<?php
namespace App\Models\Pdc;

use App\Core\Database;
use PDO;

class TrainingTypes
{
    private PDO $db;
    private string $table = 'training_types';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** Fetch all training types */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    /** Add new training type */
    public function store(string $type_name): bool
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (type_name) VALUES (:type_name)");
        return $stmt->execute(['type_name' => $type_name]);
    }

    /** Update training type */
    public function updateType(int $id, string $type_name): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET type_name = :type_name WHERE id = :id");
        return $stmt->execute([
            'type_name' => $type_name,
            'id' => $id
        ]);
    }

    /** Delete training type */
    public function deleteType(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

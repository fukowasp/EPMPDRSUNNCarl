<?php
namespace App\Models\Pdc;

use App\Core\Database;
use PDO;

class TrainingCategories
{
    protected PDO $db;
    protected string $table = 'training_categories';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** Get all training categories */
    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT id, category_name
            FROM {$this->table}
            ORDER BY id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Create new category */
    public function create(string $category_name): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (category_name)
            VALUES (:category_name)
        ");
        return $stmt->execute([':category_name' => $category_name]);
    }

    /** Update category */
    public function update(int $id, string $category_name): bool
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET category_name = :category_name
            WHERE id = :id
        ");
        return $stmt->execute([
            ':category_name' => $category_name,
            ':id' => $id
        ]);
    }

    /** Delete category */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM {$this->table}
            WHERE id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }
}

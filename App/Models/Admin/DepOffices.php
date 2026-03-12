<?php
namespace App\Models\Admin;

use App\Core\Database;
use PDO;
use Exception;

class DepOffices
{
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->conn->prepare(
            "SELECT dept_id, name FROM departments_offices ORDER BY name ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add(): bool
    {
        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            throw new Exception('Name is required');
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO departments_offices (name) VALUES (:name)"
        );

        return $stmt->execute(['name' => $name]);
    }

    public function update(): bool
    {
        $id   = (int)($_POST['dept_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');

        if ($id <= 0 || $name === '') {
            throw new Exception('Invalid input');
        }

        $stmt = $this->conn->prepare(
            "UPDATE departments_offices SET name = :name WHERE dept_id = :id"
        );

        return $stmt->execute([
            'name' => $name,
            'id'   => $id
        ]);
    }

    public function delete(int $dept_id): bool
    {
        if ($dept_id <= 0) {
            throw new Exception('Invalid department ID');
        }

        $stmt = $this->conn->prepare(
            "DELETE FROM departments_offices WHERE dept_id = :id"
        );

        return $stmt->execute(['id' => $dept_id]);
    }

}

<?php
namespace App\Models\Admin;

use App\Core\Database;
use PDO;

class GradTable
{
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    // ✅ Fetch all departments/offices (for Graduate Course dropdown)
    public function getAllCourses(): array
    {
        $stmt = $this->conn->prepare("SELECT id, course_name FROM grad_tables ORDER BY course_name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Optional — keep these CRUD functions if you still maintain grad_tables separately
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM grad_tables ORDER BY course_name ASC");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        json_response(['data' => $data]);
    }

    public function add()
    {
        $course = $_POST['course_name'] ?? '';
        $stmt = $this->conn->prepare("INSERT INTO grad_tables (course_name) VALUES (:course)");
        $success = $stmt->execute([':course' => $course]);
        json_response(['success' => $success]);
    }

    public function update()
    {
        $id = $_POST['id'] ?? 0;
        $course = $_POST['course_name'] ?? '';
        $stmt = $this->conn->prepare("UPDATE grad_tables SET course_name=:course WHERE id=:id");
        $success = $stmt->execute([':course' => $course, ':id' => $id]);
        json_response(['success' => $success]);
    }

    public function delete()
    {
        $id = $_POST['id'] ?? 0;
        $stmt = $this->conn->prepare("DELETE FROM grad_tables WHERE id=:id");
        $success = $stmt->execute([':id' => $id]);
        json_response(['success' => $success]);
    }
}

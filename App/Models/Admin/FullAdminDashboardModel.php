<?php
namespace App\Models\Admin;

use App\Core\Database;
use PDO;

class FullAdminDashboardModel
{
    protected PDO $db;
    protected string $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Get count of users by role
    public function getCountByRole(string $role): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM {$this->table} WHERE role = :role AND status = 'active'");
        $stmt->execute(['role' => $role]);
        $result = $stmt->fetch();
        return (int)($result['count'] ?? 0);
    }

    // Get all users (for Manage Accounts table)
    public function getAllUsers(): array
    {
        $stmt = $this->db->query("SELECT id, username, role, status FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get user by ID
    public function getUserById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, username, role, status FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Add new user
    public function addUser(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (username, password, role, status, created_at) 
             VALUES (:username, :password, :role, :status, NOW())"
        );
        return $stmt->execute([
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'role'     => $data['role'],
            'status'   => $data['status']
        ]);
    }

    // Update user
    public function updateUser(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['username'])) {
            $fields[] = 'username = :username';
            $params['username'] = $data['username'];
        }

        if (isset($data['password'])) {
            $fields[] = 'password = :password';
            $params['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        if (isset($data['role'])) {
            $fields[] = 'role = :role';
            $params['role'] = $data['role'];
        }

        if (isset($data['status'])) {
            $fields[] = 'status = :status';
            $params['status'] = $data['status'];
        }

        if (empty($fields)) return false;

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Delete user
    public function deleteUser(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

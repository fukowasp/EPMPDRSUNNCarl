<?php
namespace App\Models\Admin;

use App\Core\Database;
use PDO;

class AdminLogin
{
    protected $db;
    protected $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get user by username and allowed roles
     * @param string $username
     * @param array $roles
     * @return array|null
     */
    public function getByUsernameAndRoles(string $username, array $roles = ['admin']): ?array
    {
        $placeholders = implode(',', array_fill(0, count($roles), '?'));
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ? AND role IN ($placeholders) LIMIT 1");
        $stmt->execute(array_merge([$username], $roles));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}

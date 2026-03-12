<?php
namespace App\Models\Pdc;

use App\Core\Database;
use PDO;

class PdcLogin
{
    protected $db;
    protected $table = 'users'; 

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get PDC user by username
     */
    public function getByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }
}

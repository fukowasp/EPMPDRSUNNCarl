<?php
namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    /** @var ?PDO */
    private static ?PDO $instance = null;

    /** @var PDO */
    private PDO $conn;

    /** 
     * Private constructor — prevents external instantiation
     */
    private function __construct()
    {
        $host = getenv('DB_HOST') ?: 'localhost';
        $db   = getenv('DB_NAME') ?: 'hrsunne_sunnhr';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';

        try {
            $this->conn = new PDO(
                "mysql:host={$host};dbname={$db};charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
                ]
            );
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            throw new \RuntimeException('Database connection failed. Check logs for details.');
        }
    }

    /** Prevent cloning */
    private function __clone(): void {}

    /** Prevent unserializing */
    public function __wakeup(): void
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * ✅ Get the shared PDO instance
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $db = new self();
            self::$instance = $db->conn;
        }
        return self::$instance;
    }
}

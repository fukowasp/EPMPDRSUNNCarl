<?php
namespace App\Models\Employee\Login;

use App\Core\Database;
use PDO;

class Login
{
    protected PDO $pdo;
    protected string $table = 'employee_register';

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    // Check credentials
    public function checkCredentials(string $employee_id, string $password): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE employee_id = :employee_id LIMIT 1");
        $stmt->execute([':employee_id' => $employee_id]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$employee) {
            return ['status'=>'error','type'=>'id','message'=>'Employee ID not found.'];
        }

        if (!password_verify($password, $employee['password'])) {
            return ['status'=>'error','type'=>'password','message'=>'Incorrect password.'];
        }

        unset($employee['password']); // Remove sensitive data
        return ['status'=>'success', 'employee' => $employee];
    }
}

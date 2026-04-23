<?php
namespace App\Models;

use PDO;
use Dotenv\Dotenv;

class UserModel
{
    protected PDO $pdo;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();

        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $db   = $_ENV['DB_NAME'] ?? 'whm';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO users (customer_code, email, password_hash, national_id_enc, national_id_iv, national_id_hash, role_id)
                VALUES (:customer_code, :email, :password_hash, :national_id_enc, :national_id_iv, :national_id_hash, :role_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':customer_code' => $data['customer_code'],
            ':email' => $data['email'],
            ':password_hash' => $data['password_hash'],
            ':national_id_enc' => $data['national_id_enc'],
            ':national_id_iv' => $data['national_id_iv'],
            ':national_id_hash' => $data['national_id_hash'],
            ':role_id' => $data['role_id'] ?? 3
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function findByEmailOrCustomerCode(string $identifier): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :id OR customer_code = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $identifier]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getLastSequenceForYear(string $year): int
    {
        $like = "CUS-{$year}-%";
        $sql = "SELECT customer_code FROM users WHERE customer_code LIKE :like ORDER BY id DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':like' => $like]);
        $row = $stmt->fetch();
        if (!$row) return 0;
        $parts = explode('-', $row['customer_code']);
        return (int)end($parts);
    }
}

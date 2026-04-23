<?php
namespace App\Models;

use PDO;
use Dotenv\Dotenv;

class OrderModel
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
        $sql = "INSERT INTO orders (user_id, plan_id, status, amount, payment_method, metadata, created_at)
                VALUES (:user_id, :plan_id, :status, :amount, :payment_method, :metadata, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $data['user_id'] ?? null,
            ':plan_id' => $data['plan_id'] ?? null,
            ':status' => $data['status'] ?? 'pending',
            ':amount' => $data['amount'] ?? 0,
            ':payment_method' => $data['payment_method'] ?? 'unknown',
            ':metadata' => json_encode($data['metadata'] ?? []),
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = :status, updated_at = NOW() WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }
}

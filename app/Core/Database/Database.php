<?php

namespace App\Core\Database;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    private ?PDO $pdo = null;

    public function __construct(private array $config) {}

    public function pdo(): PDO
    {
        if ($this->pdo) {
            return $this->pdo;
        }

        $host = $this->config['host'] ?? '127.0.0.1';
        $port = $this->config['port'] ?? '3306';
        $name = $this->config['name'] ?? '';
        $user = $this->config['user'] ?? '';
        $pass = $this->config['pass'] ?? '';
        $charset = $this->config['charset'] ?? 'utf8mb4';

        if ($name === '') {
            throw new RuntimeException("DB_NAME não definido.");
        }

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

        try {
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException("Erro ligação DB: " . $e->getMessage(), 0, $e);
        }

        return $this->pdo;
    }

    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function exec(string $sql, array $params = []): int
    {
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function lastInsertId(): string
    {
        return $this->pdo()->lastInsertId();
    }
}
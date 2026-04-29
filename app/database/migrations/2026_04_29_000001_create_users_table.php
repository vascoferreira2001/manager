<?php

use App\Core\Database\Database;
use App\Core\Database\Migration;

return new class extends Migration {

    public function up(Database $db): void
    {
        $db->exec("
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(120) NOT NULL,
                email VARCHAR(190) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(50) NOT NULL DEFAULT 'client',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public function down(Database $db): void
    {
        $db->exec('DROP TABLE IF EXISTS users');
    }
};
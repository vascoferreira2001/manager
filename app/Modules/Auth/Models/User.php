<?php

namespace App\Modules\Auth\Models;

use System\Database;
use PDO;

class User
{
    public static function findByEmail($email)
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO users (name, email, password, role)
            VALUES (:name, :email, :password, :role)
        ");

        return $stmt->execute($data);
    }
}
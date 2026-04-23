<?php

namespace App\Models;

use System\Database;
use PDO;

class Client
{
    public static function all()
    {
        $db = Database::connect();
        return $db->query("SELECT * FROM clients")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO clients (name, email)
            VALUES (:name, :email)
        ");

        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email']
        ]);
    }
}
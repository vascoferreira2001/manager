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

    public static function find($id)
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO clients (name, email)
            VALUES (?, ?)
        ");

        return $stmt->execute([
            $data['name'],
            $data['email']
        ]);
    }

    public static function update($id, $data)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            UPDATE clients
            SET name = ?, email = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['name'],
            $data['email'],
            $id
        ]);
    }

    public static function delete($id)
    {
        $db = Database::connect();

        $stmt = $db->prepare("DELETE FROM clients WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
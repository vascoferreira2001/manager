<?php

namespace App\Modules\Hosting\Models;

class Hosting
{
    public static function create($data)
    {
        $db = \System\Database::connect();

        $stmt = $db->prepare("
            INSERT INTO hostings 
            (client_id, domain, username, password, status, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $data['client_id'],
            $data['domain'],
            $data['username'],
            $data['password'],
            $data['status']
        ]);

        return $db->lastInsertId();
    }
}
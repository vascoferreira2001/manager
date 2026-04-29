<?php

namespace App\Modules\Hosting\Services;

use System\Database;

class HostingService
{
    public static function createHosting($clientId, $data)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO hostings 
            (client_id, order_id, domain, username, password, status, created_at)
            VALUES (?, ?, ?, ?, ?, 'active', NOW())
        ");

        $stmt->execute([
            $clientId,
            $data['order_id'],
            $data['domain'],
            $data['username'],
            $data['password']
        ]);

        return $db->lastInsertId();
    }
}
<?php

namespace App\Modules\Hosting\Repositories;

use System\Database;

class HostingRepository
{
    public static function getClientHostings($clientId)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT *
            FROM hosting_accounts
            WHERE client_id = ?
            ORDER BY id DESC
        ");

        $stmt->execute([$clientId]);

        return $stmt->fetchAll();
    }

    public static function find($id)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT *
            FROM hosting_accounts
            WHERE id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);

        return $stmt->fetch();
    }
}
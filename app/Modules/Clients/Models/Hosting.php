<?php

namespace App\Modules\Clients\Models;

use System\Database;

class Hosting
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function findByIdAndClient($id, $clientId)
    {
        $stmt = $this->db->prepare("
            SELECT ha.*, o.client_id
            FROM hosting_accounts ha
            JOIN orders o ON o.id = ha.order_id
            WHERE ha.id = ? AND o.client_id = ?
        ");

        $stmt->execute([$id, $clientId]);

        return $stmt->fetch();
    }

    public function getByClient($clientId)
    {
        $stmt = $this->db->prepare("
            SELECT ha.*
            FROM hosting_accounts ha
            JOIN orders o ON o.id = ha.order_id
            WHERE o.client_id = ?
            ORDER BY ha.id DESC
        ");

        $stmt->execute([$clientId]);

        return $stmt->fetchAll();
    }

    public function updatePassword($id, $password)
    {
        $stmt = $this->db->prepare("
            UPDATE hosting_accounts
            SET password = ?
            WHERE id = ?
        ");

        return $stmt->execute([$password, $id]);
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE hosting_accounts
            SET status = ?
            WHERE id = ?
        ");

        return $stmt->execute([$status, $id]);
    }
}
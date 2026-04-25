<?php

namespace App\Modules\Clients\Services;

use System\Database;

class ClientDashboardService
{
    public static function getOverview($clientId)
    {
        $db = Database::connect();

        // Hosting
        $stmt = $db->prepare("
            SELECT ha.*
            FROM hosting_accounts ha
            JOIN orders o ON o.id = ha.order_id
            WHERE o.client_id = ?
        ");
        $stmt->execute([$clientId]);
        $hosting = $stmt->fetchAll();

        // Orders
        $stmt = $db->prepare("
            SELECT * FROM orders WHERE client_id = ?
        ");
        $stmt->execute([$clientId]);
        $orders = $stmt->fetchAll();

        // Invoices
        $stmt = $db->prepare("
            SELECT * FROM invoices WHERE client_id = ?
        ");
        $stmt->execute([$clientId]);
        $invoices = $stmt->fetchAll();

        return [
            'hosting' => $hosting,
            'orders' => $orders,
            'invoices' => $invoices
        ];
    }
}
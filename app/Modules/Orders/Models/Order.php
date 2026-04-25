<?php

namespace App\Modules\Orders\Models;

use System\Database;
use PDO;

class Order
{
    public static function create($clientId, $total)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO orders (client_id, total)
            VALUES (?, ?)
        ");

        $stmt->execute([$clientId, $total]);

        return $db->lastInsertId();
    }

    public static function addItem($orderId, $item)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO order_items (order_id, product_id, product_name, quantity, price)
            VALUES (?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $orderId,
            $item['product_id'],
            $item['name'],
            $item['quantity'],
            $item['price']
        ]);
    }

    public static function markAsPaid($orderId)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            UPDATE orders SET status = 'paid' WHERE id = ?
        ");

        return $stmt->execute([$orderId]);
    }
}
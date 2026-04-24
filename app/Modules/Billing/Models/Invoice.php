<?php

namespace App\Modules\Billing\Models;

use System\Database;
use PDO;

class Invoice
{
    public static function create($data)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO invoices (client_id, total, status, due_date)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['client_id'],
            $data['total'],
            'unpaid',
            $data['due_date']
        ]);

        return $db->lastInsertId();
    }

    public static function addItem($invoiceId, $item)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO invoice_items (invoice_id, description, quantity, price)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $invoiceId,
            $item['description'],
            $item['quantity'],
            $item['price']
        ]);
    }

    public static function find($id)
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM invoices WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function markAsPaid($id)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            UPDATE invoices SET status = 'paid' WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}
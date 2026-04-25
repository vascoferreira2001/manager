<?php

namespace App\Modules\Products\Models;

use System\Database;

class Product
{
    public static function find($id)
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public static function getPlan($productId)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT * FROM product_plans WHERE product_id = ?
        ");
        $stmt->execute([$productId]);

        return $stmt->fetch();
    }
}
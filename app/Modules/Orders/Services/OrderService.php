<?php

namespace App\Modules\Orders\Services;

use App\Modules\Orders\Models\Order;
use App\Modules\Billing\Services\BillingService;

class OrderService
{
    public static function createOrder($clientId, $items)
    {
        $total = 0;

        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Criar order
        $orderId = Order::create($clientId, $total);

        foreach ($items as $item) {
            Order::addItem($orderId, $item);
        }

        // 🔥 Criar invoice automaticamente
        $invoiceId = BillingService::createInvoice(
            $clientId,
            $items,
            date('Y-m-d', strtotime('+7 days')),
            $orderId
        );

        return [
            'order_id' => $orderId,
            'invoice_id' => $invoiceId
        ];
    }
}
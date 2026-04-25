<?php

namespace App\Modules\Orders\Services;

use App\Modules\Orders\Models\Order;
use App\Modules\Billing\Services\BillingService;

class OrderService
{
    public static function createOrder($clientId, $items)
    {
        // 🔒 Validar items
        if (empty($items)) {
            throw new \Exception("Order sem items não é válida");
        }

        $total = 0;

        // 🔧 Normalizar e validar items
        foreach ($items as &$item) {

            if (!isset($item['price'], $item['quantity'])) {
                throw new \Exception("Item inválido na order");
            }

            $item['price'] = (float) $item['price'];
            $item['quantity'] = (int) $item['quantity'];

            $total += $item['price'] * $item['quantity'];
        }

        // 🧾 Criar order
        $orderId = Order::create($clientId, $total);

        if (!$orderId) {
            throw new \Exception("Falha ao criar order");
        }

        // 📦 Guardar items
        foreach ($items as $item) {
            Order::addItem($orderId, $item);
        }

        // 💳 Criar invoice com metadata para Stripe/Webhook
        $invoiceId = BillingService::createInvoice(
            $clientId,
            $items,
            date('Y-m-d', strtotime('+7 days')),
            $orderId
        );

        if (!$invoiceId) {
            throw new \Exception("Falha ao criar invoice");
        }

        // 🔥 Return estruturado (pronto para checkout)
        return [
            'order_id' => $orderId,
            'invoice_id' => $invoiceId,
            'total' => $total,
            'items' => $items
        ];
    }
}
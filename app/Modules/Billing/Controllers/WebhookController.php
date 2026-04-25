<?php

namespace App\Modules\Billing\Controllers;

use Stripe\Webhook;
use App\Modules\Billing\Models\Invoice;
use App\Modules\Orders\Models\Order;
use System\Database;

class WebhookController
{
    public function handle()
    {
        require __DIR__ . '/../../../../vendor/autoload.php';

        $config = require __DIR__ . '/../../../../config/stripe.php';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $config['webhook_secret']
            );
        } catch (\Exception $e) {
            http_response_code(400);
            exit();
        }

        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            $invoiceId = $session->metadata->invoice_id ?? null;

            if ($invoiceId) {

                // 1. Marcar invoice como paga
                Invoice::markAsPaid($invoiceId);

                // 2. Obter order associada
                $db = Database::connect();

                $stmt = $db->prepare("
                    SELECT order_id FROM invoices WHERE id = ?
                ");

                $stmt->execute([$invoiceId]);

                $orderId = $stmt->fetchColumn();

                // 3. Marcar order como paga
                if ($orderId) {
                    Order::markAsPaid($orderId);
                }
            }
        }

        http_response_code(200);
    }
}
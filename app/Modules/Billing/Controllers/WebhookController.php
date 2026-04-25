<?php

namespace App\Modules\Billing\Controllers;

use Stripe\Webhook;
use App\Modules\Billing\Models\Invoice;
use App\Modules\Orders\Models\Order;
use System\Database;

use App\Modules\Provisioning\Services\ProvisioningService;

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

    if ($session->payment_status !== 'paid') {
        http_response_code(200);
        return;
    }

    $invoiceId = $session->metadata->invoice_id ?? null;

    if (!$invoiceId) {
        http_response_code(400);
        return;
    }

    $db = Database::connect();

    try {

        $db->beginTransaction();

        $stmt = $db->prepare("
            SELECT id, status, order_id 
            FROM invoices 
            WHERE id = ?
            FOR UPDATE
        ");
        $stmt->execute([$invoiceId]);

        $invoice = $stmt->fetch();

        if (!$invoice) {
            throw new \Exception("Invoice não encontrada");
        }

        if ($invoice['status'] === 'paid') {
            $db->commit();
            http_response_code(200);
            return;
        }

        // Invoice → paid
        $stmt = $db->prepare("
            UPDATE invoices SET status = 'paid' WHERE id = ?
        ");
        $stmt->execute([$invoiceId]);

        $orderId = $invoice['order_id'] ?? null;

        // Order → paid
        if ($orderId) {
            $stmt = $db->prepare("
                UPDATE orders SET status = 'paid' WHERE id = ?
            ");
            $stmt->execute([$orderId]);
        }

        $db->commit();

        // 🚀 Provisionamento fora da transação
        if ($orderId) {
            try {
                ProvisioningService::provisionOrder($orderId);
            } catch (\Exception $e) {
                error_log("Provisioning Error: " . $e->getMessage());
            }
        }

    } catch (\Exception $e) {

        $db->rollBack();

        error_log("Stripe Webhook Error: " . $e->getMessage());

        http_response_code(500);
        return;
    }
}

    }
}
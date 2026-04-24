<?php

namespace App\Modules\Billing\Controllers;

use Stripe\Webhook;
use App\Modules\Billing\Models\Invoice;

class WebhookController
{
    public function handle()
    {
        require base_path('vendor/autoload.php');

        $config = require base_path('config/stripe.php');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

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

            $invoiceId = $session->metadata->invoice_id;

            Invoice::markAsPaid($invoiceId);
        }

        http_response_code(200);
    }
}
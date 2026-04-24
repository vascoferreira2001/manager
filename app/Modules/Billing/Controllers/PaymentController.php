<?php

namespace App\Modules\Billing\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Modules\Billing\Models\Invoice;

class PaymentController
{
    public function checkout()
    {
        require base_path('vendor/autoload.php');

        $config = require base_path('config/stripe.php');

        Stripe::setApiKey($config['secret']);

        $invoiceId = $_GET['invoice_id'];
        $invoice = Invoice::find($invoiceId);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => "Invoice #{$invoice['id']}"
                    ],
                    'unit_amount' => $invoice['total'] * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://localhost/cancel',
            'metadata' => [
                'invoice_id' => $invoice['id']
            ]
        ]);

        header("Location: " . $session->url);
        exit;
    }
}
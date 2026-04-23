<?php
namespace App\Controllers;

class CheckoutController
{
    // POST /checkout
    public function create(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        // Espera: plan_code, user_id (ou guest email), payment_method (stripe|paypal|bank)
        if (empty($data['plan_code']) || empty($data['payment_method'])) {
            http_response_code(400);
            echo json_encode(['error' => 'plan_code and payment_method required']);
            return;
        }

        // Criar order na BD (status: pending)
        // Se Stripe/PayPal: criar session via PaymentService e retornar checkout_url
        // Se bank transfer: gerar reference única e instruções

        http_response_code(201);
        echo json_encode(['checkout_url' => 'https://checkout.example/test']);
    }
}

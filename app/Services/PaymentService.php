<?php
namespace App\Services;

class PaymentService
{
    public function createStripeSession(array $order): array
    {
        // Usar stripe-php se instalado; aqui apenas skeleton
        // Retornar ['id' => 'cs_test_xxx', 'url' => 'https://checkout.stripe.com/...']
        return ['id' => 'cs_test_dummy', 'url' => 'https://stripe.com/checkout'];
    }

    public function createPayPalOrder(array $order): array
    {
        // Usar SDK PayPal; retornar approval URL
        return ['id' => 'paypal_dummy', 'url' => 'https://paypal.com/checkout'];
    }

    public function generateBankReference(array $order): string
    {
        // Gerar referência única: e.g., ORD-{timestamp}-{random}
        return 'REF-' . time() . '-' . substr(md5(random_bytes(6)), 0, 6);
    }
}

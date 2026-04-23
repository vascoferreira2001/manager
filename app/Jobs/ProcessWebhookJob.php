<?php
namespace App\Jobs;

use App\Models\PaymentModel;
use App\Models\OrderModel;
use App\Models\InvoiceModel;
use App\Models\UserModel;

class ProcessWebhookJob
{
    public function handle(array $data)
    {
        $gateway = $data['gateway'] ?? 'unknown';
        $payload = $data['payload'] ?? [];

        // Exemplo de idempotência: usar event id ou transaction id
        $eventId = $payload['id'] ?? ($payload['event_id'] ?? null);
        if ($eventId && $this->alreadyProcessed($gateway, $eventId)) {
            return;
        }

        // Lógica simplificada: detectar pagamento bem sucedido e criar order/invoice
        if ($gateway === 'stripe') {
            $type = $payload['type'] ?? null;
            if ($type === 'checkout.session.completed' || $type === 'payment_intent.succeeded') {
                $session = $payload['data']['object'] ?? [];
                $this->processPayment($gateway, $session, $eventId);
            }
        } elseif ($gateway === 'paypal') {
            // adaptar conforme payload PayPal
            $this->processPayment($gateway, $payload, $eventId);
        }

        // registar que o eventId foi processado (implementar tabela payments/events)
    }

    protected function alreadyProcessed($gateway, $eventId): bool
    {
        // Implementar verificação em BD: payments table ou webhook_events
        return false;
    }

    protected function processPayment($gateway, $object, $eventId = null)
    {
        // Exemplo: extrair email, amount, metadata
        $email = $object['customer_details']['email'] ?? $object['payer']['email_address'] ?? null;
        $amount = $object['amount_total'] ?? $object['amount'] ?? null;
        $metadata = $object['metadata'] ?? [];

        // Lógica: localizar user por email, criar order/invoice, marcar pagamento
        // Implementar conforme modelos reais
    }
}

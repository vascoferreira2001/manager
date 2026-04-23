<?php
namespace App\Controllers;

use App\Libraries\Queue;

class WebhookController
{
    protected Queue $queue;

    public function __construct()
    {
        $this->queue = new Queue();
    }

    // POST /webhook/stripe
    public function stripe(): void
    {
        // Ler payload bruto
        $payload = json_decode(file_get_contents('php://input'), true);
        // Responder 200 rapidamente
        http_response_code(200);
        echo json_encode(['received' => true]);

        // Enfileirar processamento assíncrono
        $this->queue->push(\App\Jobs\ProcessWebhookJob::class, [
            'gateway' => 'stripe',
            'payload' => $payload
        ]);
    }

    // POST /webhook/paypal
    public function paypal(): void
    {
        $payload = json_decode(file_get_contents('php://input'), true);
        http_response_code(200);
        echo json_encode(['received' => true]);
        $this->queue->push(\App\Jobs\ProcessWebhookJob::class, [
            'gateway' => 'paypal',
            'payload' => $payload
        ]);
    }
}

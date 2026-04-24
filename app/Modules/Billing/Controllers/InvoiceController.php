<?php

namespace App\Modules\Billing\Controllers;

use App\Modules\Auth\Middleware\AuthMiddleware;
use App\Modules\Auth\Middleware\PermissionMiddleware;
use App\Modules\Billing\Services\BillingService;

class InvoiceController
{
    public function __construct()
    {
        AuthMiddleware::check();
    }

    public function create()
    {
        echo '
        <h2>Criar Fatura</h2>
        <form method="POST" action="/invoices/store">
            <input name="client_id" placeholder="Client ID"><br>
            <input name="description" placeholder="Descrição"><br>
            <input name="quantity" placeholder="Quantidade"><br>
            <input name="price" placeholder="Preço"><br>
            <input name="due_date" type="date"><br>

            <button>Criar</button>
        </form>
        ';
    }

    public function store()
    {
        $items = [[
            'description' => $_POST['description'],
            'quantity' => $_POST['quantity'],
            'price' => $_POST['price']
        ]];

        BillingService::createInvoice(
            $_POST['client_id'],
            $items,
            $_POST['due_date']
        );

        header("Location: /dashboard");
        exit;
    }
}
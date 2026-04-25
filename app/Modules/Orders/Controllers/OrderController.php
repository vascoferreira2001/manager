<?php

namespace App\Modules\Orders\Controllers;

use App\Modules\Auth\Middleware\AuthMiddleware;
use App\Modules\Orders\Services\OrderService;

class OrderController
{
    public function __construct()
    {
        AuthMiddleware::check();
    }

    public function create()
    {
        echo '
        <h2>Nova Encomenda</h2>
        <form method="POST" action="/orders/store">
            <input name="product" placeholder="Produto"><br>
            <input name="quantity" placeholder="Quantidade"><br>
            <input name="price" placeholder="Preço"><br>
            <button>Comprar</button>
        </form>
        ';
    }

    public function store()
    {
        $clientId = $_SESSION['user']['id'];

        $items = [[
            'name' => $_POST['product'],
            'quantity' => $_POST['quantity'],
            'price' => $_POST['price']
        ]];

        $result = OrderService::createOrder($clientId, $items);

        // Redireciona para pagamento
        header("Location: /pay?invoice_id=" . $result['invoice_id']);
        exit;
    }
}
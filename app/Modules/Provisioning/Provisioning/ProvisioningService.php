<?php

namespace App\Modules\Provisioning\Services;

use System\Database;
use App\Modules\Provisioning\Drivers\PleskDriver;
use App\Modules\Provisioning\DTO\ProvisioningData;
use App\Modules\Products\Models\Product;

class ProvisioningService
{
    public static function provisionOrder($orderId)
    {
        $db = Database::connect();

        // 🔁 Evitar duplicação
        $stmt = $db->prepare("
            SELECT id FROM hosting_accounts WHERE order_id = ?
        ");
        $stmt->execute([$orderId]);

        if ($stmt->fetch()) {
            return; // já provisionado
        }

        // 👤 Cliente
        $stmt = $db->prepare("
            SELECT c.name, c.email
            FROM clients c
            JOIN orders o ON o.client_id = c.id
            WHERE o.id = ?
        ");
        $stmt->execute([$orderId]);

        $client = $stmt->fetch();

        if (!$client) {
            throw new \Exception("Cliente não encontrado");
        }

        // 📦 Produto da order
        $stmt = $db->prepare("
            SELECT product_id
            FROM order_items
            WHERE order_id = ?
            LIMIT 1
        ");
        $stmt->execute([$orderId]);

        $item = $stmt->fetch();

        if (!$item) {
            throw new \Exception("Produto não encontrado na order");
        }

        // 📋 Plano do produto
        $plan = Product::getPlan($item['product_id']);

        if (!$plan) {
            throw new \Exception("Plano não configurado para este produto");
        }

        // 🌐 Dados de hosting
        $domain = "cliente{$orderId}.cybercore.pt";
        $username = "user{$orderId}";
        $password = bin2hex(random_bytes(6));

        $data = new ProvisioningData([
            'domain' => $domain,
            'username' => $username,
            'password' => $password,
            'email' => $client['email'],
            'name' => $client['name'],
            'plan' => $plan['plesk_plan_name']
        ]);

        $driver = new PleskDriver();

        try {

            $response = $driver->create($data);

            // 💾 Sucesso
            $stmt = $db->prepare("
                INSERT INTO hosting_accounts 
                (order_id, domain, username, password, status)
                VALUES (?, ?, ?, ?, 'active')
            ");

            $stmt->execute([
                $orderId,
                $domain,
                $username,
                $password
            ]);

            return $response;

        } catch (\Exception $e) {

            // 💾 Falha
            $stmt = $db->prepare("
                INSERT INTO hosting_accounts 
                (order_id, domain, username, password, status)
                VALUES (?, ?, ?, ?, 'failed')
            ");

            $stmt->execute([
                $orderId,
                $domain,
                $username,
                $password
            ]);

            throw $e;
        }
    }
}
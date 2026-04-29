<?php

namespace App\Modules\Provisioning\Provisioning;

use System\Database;
use App\Modules\Provisioning\Drivers\PleskDriver;
use App\Modules\Provisioning\DTO\ProvisioningData;
use App\Modules\Products\Models\Product;
use App\Modules\Hosting\Services\HostingService;

class ProvisioningService
{
    public static function provisionOrder($orderId)
    {
        $db = Database::connect();

        // 🔒 TRANSAÇÃO
        $db->beginTransaction();

        try {

            // 🔁 Evitar duplicação
            $stmt = $db->prepare("
                SELECT id FROM hostings WHERE order_id = ?
                FOR UPDATE
            ");
            $stmt->execute([$orderId]);

            if ($stmt->fetch()) {
                $db->commit();
                return;
            }

            // 👤 Cliente
            $stmt = $db->prepare("
                SELECT c.id, c.name, c.email
                FROM clients c
                JOIN orders o ON o.client_id = c.id
                WHERE o.id = ?
            ");
            $stmt->execute([$orderId]);

            $client = $stmt->fetch();

            if (!$client) {
                throw new \Exception("Cliente não encontrado");
            }

            // 📦 Produto
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

            // 📋 Plano
            $plan = Product::getPlan($item['product_id']);

            if (!$plan) {
                throw new \Exception("Plano não configurado");
            }

            // 🌐 Dados
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

            // 🚀 Provisionamento
            $driver = new PleskDriver();
            $driver->create($data);

            // 💾 Guardar hosting (camada correta)
            HostingService::createHosting($client['id'], [
                'order_id' => $orderId,
                'domain' => $domain,
                'username' => $username,
                'password' => $password
            ]);

            $db->commit();

        } catch (\Exception $e) {

            $db->rollBack();

            error_log("Provisioning Error: " . $e->getMessage());

            throw $e;
        }
    }
}
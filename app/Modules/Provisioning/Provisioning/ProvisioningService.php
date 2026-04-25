<?php

namespace App\Modules\Provisioning\Services;

use App\Modules\Provisioning\Drivers\PleskDriver;
use App\Modules\Provisioning\DTO\ProvisioningData;
use System\Database;

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

        // 🔎 Buscar cliente
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

        // ⚠️ TEMPORÁRIO (depois vem de produtos)
        $domain = "cliente{$orderId}.cybercore.pt";
        $username = "user{$orderId}";
        $password = bin2hex(random_bytes(6));

        $data = new ProvisioningData([
            'domain' => $domain,
            'username' => $username,
            'password' => $password,
            'email' => $client['email'],
            'name' => $client['name']
        ]);

        $driver = new PleskDriver();

        try {

            $response = $driver->create($data);

            // 💾 Guardar sucesso
            $stmt = $db->prepare("
                INSERT INTO hosting_accounts (order_id, domain, username, password, status)
                VALUES (?, ?, ?, ?, 'active')
            ");
            $stmt->execute([$orderId, $domain, $username, $password]);

            return $response;

        } catch (\Exception $e) {

            // 💾 Guardar falha
            $stmt = $db->prepare("
                INSERT INTO hosting_accounts (order_id, domain, username, password, status)
                VALUES (?, ?, ?, ?, 'failed')
            ");
            $stmt->execute([$orderId, $domain, $username, $password]);

            throw $e;
        }
    }
}
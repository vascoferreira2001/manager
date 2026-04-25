<?php

namespace App\Modules\Provisioning\Drivers;

use App\Modules\Provisioning\DTO\ProvisioningData;

class PleskDriver
{
    private function request($endpoint, $data)
    {
        $config = require __DIR__ . '/../../../../config/plesk.php';

        $auth = base64_encode($config['username'] . ':' . $config['password']);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $config['host'] . '/api/v2' . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . $auth
            ],
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('Erro cURL: ' . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    public function create(ProvisioningData $data)
    {
        // 1. Criar cliente
        $this->request('/customers', [
            'name' => $data->name,
            'email' => $data->email
        ]);

        // 2. Criar subscription
        return $this->request('/webspaces', [
            'name' => $data->domain,
            'hosting_type' => 'virtual',
            'login' => $data->username,
            'password' => $data->password
        ]);
    }
}
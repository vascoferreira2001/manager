<?php

namespace App\Modules\Provisioning\Services;

class PleskService
{
    public static function createCustomer($email, $name)
    {
        $config = require __DIR__ . '/../../../../config/plesk.php';

        $data = [
            'name' => $name,
            'email' => $email
        ];

        return self::request('/customers', $data);
    }

    public static function createSubscription($domain, $username, $password)
    {
        $config = require __DIR__ . '/../../../../config/plesk.php';

        $data = [
            'domain' => $domain,
            'login' => $username,
            'password' => $password
        ];

        return self::request('/webspaces', $data);
    }

    private static function request($endpoint, $data)
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
            CURLOPT_SSL_VERIFYPEER => false // ⚠️ dev only
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }
}
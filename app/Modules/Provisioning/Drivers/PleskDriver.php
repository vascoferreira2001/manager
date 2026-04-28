<?php

namespace App\Modules\Provisioning\Drivers;

class PleskDriver
{
    private function request($endpoint, $data = [], $method = 'POST')
    {
        $config = require __DIR__ . '/../../../../Config/plesk.php';

        $auth = base64_encode($config['username'] . ':' . $config['password']);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => rtrim($config['host'], '/') . '/api/v2' . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . $auth
            ],
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }


    public function changePassword($domain, $password)
    {
        return $this->request("/webspaces/{$domain}", [
            'hosting_settings' => [
                'password' => $password
            ]
        ], 'PUT');
    }

    public function create(\App\Modules\Provisioning\DTO\ProvisioningData $data)
    {
        $payload = [
            'domain' => $data->domain,
            'hosting' => [
                'login' => $data->username,
                'password' => $data->password,
                'plan' => $data->plan
            ],
            'owner' => [
                'email' => $data->email,
                'name' => $data->name
            ]
        ];

        return $this->request('/webspaces', $payload, 'POST');
    }
    public function suspend($domain)
    {
        return $this->request("/webspaces/{$domain}/suspend");
    }

    public function unsuspend($domain)
    {
        return $this->request("/webspaces/{$domain}/unsuspend");
    }

    public function generateLoginUrl($domain)
    {
        $response = $this->request("/server/login", [
            'params' => [
                'domain' => $domain
            ]
        ]);

        if (!isset($response['redirect'])) {
            throw new \Exception("SSO falhou");
        }

        return $response['redirect'];
    }
}
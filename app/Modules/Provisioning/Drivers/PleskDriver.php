<?php

namespace App\Modules\Provisioning\Drivers;

use App\Modules\Provisioning\DTO\ProvisioningData;

class PleskDriver
{
    private string $baseUrl;
    private string $auth;

    public function __construct()
    {
        $config = require __DIR__ . '/../../../../Config/plesk.php';

        $this->baseUrl = rtrim($config['host'], '/') . '/api/v2';
        $this->auth = base64_encode($config['username'] . ':' . $config['password']);
    }

    // =========================
    // 🚀 CREATE HOSTING
    // =========================
    public function create(ProvisioningData $data)
    {
        return $this->request('POST', '/webspaces', [
            'name' => $data->domain,
            'hosting_type' => 'virtual',
            'owner_login' => $data->username,
            'owner_password' => $data->password,
            'plan' => $data->plan
        ]);
    }

    // =========================
    // 🔒 SUSPEND
    // =========================
    public function suspend($domain)
    {
        return $this->request('PUT', "/webspaces/{$domain}/suspend");
    }

    public function unsuspend($domain)
    {
        return $this->request('PUT', "/webspaces/{$domain}/unsuspend");
    }

    // =========================
    // 🔑 RESET PASSWORD
    // =========================
    public function changePassword($domain, $password)
    {
        return $this->request('PUT', "/webspaces/{$domain}", [
            'hosting' => [
                'ftp_login' => $domain,
                'ftp_password' => $password
            ]
        ]);
    }

    // =========================
    // 🔐 SSO LOGIN
    // =========================
    public function generateSSO($domain)
    {
        return $this->request('POST', '/login', [
            'domain' => $domain
        ]);
    }

    // =========================
    // 🔧 CORE REQUEST
    // =========================
    private function request($method, $endpoint, $data = [])
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL => $this->baseUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . $this->auth
            ],
            CURLOPT_SSL_VERIFYPEER => false // ⚠️ apenas dev
        ];

        // Método
        switch ($method) {
            case 'POST':
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = json_encode($data);
                break;

            case 'PUT':
                $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $options[CURLOPT_POSTFIELDS] = json_encode($data);
                break;

            case 'GET':
                // nada extra
                break;
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        // ❗ erro de rede
        if ($response === false) {
            $error = curl_error($ch);
            throw new \Exception("cURL error: " . $error);
        }

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // ❗ erro API
        if ($status >= 400) {
            throw new \Exception("Plesk API error ({$status}): " . $response);
        }

        // ❌ NÃO usar curl_close (deprecated em handles modernos)

        return json_decode($response, true);
    }
}
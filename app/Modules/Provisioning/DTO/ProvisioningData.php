<?php

namespace App\Modules\Provisioning\DTO;

class ProvisioningData
{
    public string $domain;
    public string $username;
    public string $password;
    public string $email;
    public string $name;
    public string $plan;

    public function __construct($data)
    {
        $this->domain = $data['domain'];
        $this->username = $data['username'];
        $this->password = $data['password'];
        $this->email = $data['email'];
        $this->name = $data['name'];
        $this->plan = $data['plan'];
    }
}
<?php

namespace App\Modules\Auth\Services;

use RobThree\Auth\TwoFactorAuth;

class TwoFactorService
{
    private $tfa;

    public function __construct()
    {
        $this->tfa = new TwoFactorAuth('WHMS');
    }

    public function generateSecret()
    {
        return $this->tfa->createSecret();
    }

    public function getQRCode($email, $secret)
    {
        return $this->tfa->getQRCodeImageAsDataUri($email, $secret);
    }

    public function verify($secret, $code)
    {
        return $this->tfa->verifyCode($secret, $code);
    }
}
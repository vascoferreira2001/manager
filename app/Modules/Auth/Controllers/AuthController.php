<?php

namespace App\Modules\Auth\Controllers;

use App\Modules\Auth\Services\AuthService;
use App\Modules\Auth\Services\TwoFactorService;

class AuthController
{
    private $auth;
    private $tfa;

    public function __construct()
    {
        session_start();
        $this->auth = new AuthService();
        $this->tfa = new TwoFactorService();
    }

    public function loginForm()
    {
        echo '
        <form method="POST" action="/login">
            <input name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <button>Login</button>
        </form>';
    }

    public function login()
    {
        $user = $this->auth->attempt($_POST['email'], $_POST['password']);

        if (!$user) {
            echo "Login inválido";
            return;
        }

        if ($user['twofa_enabled']) {
            header("Location: /2fa");
            return;
        }

        $this->auth->completeLogin($user);
        header("Location: /dashboard");
    }

    public function twoFAForm()
    {
        echo '
        <form method="POST" action="/2fa">
            <input name="code" placeholder="Código 2FA">
            <button>Verificar</button>
        </form>';
    }

    public function verify2FA()
    {
        $user = $_SESSION['temp_user'];

        if (!$user) {
            header("Location: /login");
            return;
        }

        if ($this->tfa->verify($user['twofa_secret'], $_POST['code'])) {
            $this->auth->completeLogin($user);
            header("Location: /dashboard");
        } else {
            echo "Código inválido";
        }
    }

    public function logout()
    {
        $this->auth->logout();
        header("Location: /login");
    }
}
<?php

namespace App\Modules\Auth\Services;

use App\Modules\Auth\Models\User;

class AuthService
{
    public function login($email, $password)
    {
        $user = User::findByEmail($email);

        if (!$user) return false;

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }

    public function attempt($email, $password)
    {
        $user = $this->login($email, $password);

        if (!$user) return false;

        $_SESSION['temp_user'] = $user;

        return $user;
    }

    public function completeLogin($user)
    {
        $_SESSION['user'] = $user;
        unset($_SESSION['temp_user']);
    }

    public function logout()
    {
        session_destroy();
    }

    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }
}
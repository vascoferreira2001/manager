<?php

namespace App\Modules\Auth\Middleware;

use App\Core\Session;

class AuthMiddleware
{
    public static function check()
    {
        Session::start();

        if (!Session::get('user_id') && !Session::get('client_id')) {
            header("Location: /login");
            exit;
        }
    }
}
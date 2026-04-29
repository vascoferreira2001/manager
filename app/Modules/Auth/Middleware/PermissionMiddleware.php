<?php

namespace App\Modules\Auth\Middleware;

use App\Core\Session;
use App\Modules\Services\RBACService;

class PermissionMiddleware
{
    public static function check($permission = null)
    {
        Session::start();

        $userId = Session::get('user_id');

        if (!$userId) {
            header("Location: /login");
            exit;
        }

        if ($permission && !RBACService::hasPermission($userId, $permission)) {
            http_response_code(403);
            die("Sem permissão.");
        }
    }
}
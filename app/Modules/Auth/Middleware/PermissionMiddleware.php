<?php

namespace App\Modules\Auth\Middleware;

use App\Modules\Auth\Services\RBACService;

class PermissionMiddleware
{
    public static function handle($permission)
    {
        session_start();

        // Verifica se está autenticado
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $user = $_SESSION['user'];

        // Verifica permissão
        if (!RBACService::hasPermission($user['id'], $permission)) {
            http_response_code(403);
            echo "403 - Sem permissão";
            exit;
        }
    }
}
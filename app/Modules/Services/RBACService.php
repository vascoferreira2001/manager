<?php

namespace App\Modules\Auth\Services;

use System\Database;
use PDO;

class RBACService
{
    public static function userPermissions($userId)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT p.slug
            FROM permissions p
            JOIN role_permissions rp ON rp.permission_id = p.id
            JOIN roles r ON r.id = rp.role_id
            JOIN user_roles ur ON ur.role_id = r.id
            WHERE ur.user_id = ?
        ");

        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function hasPermission($userId, $permission)
    {
        $permissions = self::userPermissions($userId);
        return in_array($permission, $permissions);
    }
}
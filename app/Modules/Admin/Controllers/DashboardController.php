<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Auth\Middleware\AuthMiddleware;

class DashboardController
{
    public function __construct()
    {
        AuthMiddleware::check();
    }

    public function index()
    {
        echo "<h1>Admin Dashboard</h1>";

        echo "<a href='/admin/users'>Gestão de Utilizadores</a><br>";
        echo "<a href='/admin/roles'>Gestão de Roles</a><br>";
    }
}
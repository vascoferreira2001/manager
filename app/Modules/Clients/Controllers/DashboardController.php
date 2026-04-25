<?php

namespace App\Modules\Clients\Controllers;

use App\Modules\Clients\Services\ClientDashboardService;

class DashboardController
{
    public function index()
    {
        session_start();

        $clientId = $_SESSION['client_id'] ?? null;

        if (!$clientId) {
            header("Location: /login");
            exit;
        }

        $data = ClientDashboardService::getOverview($clientId);

        require __DIR__ . '/../Views/dashboard/index.php';
    }

    public function hosting()
    {
        session_start();

        $clientId = $_SESSION['client_id'] ?? null;

        if (!$clientId) {
            header("Location: /login");
            exit;
        }

        $data = ClientDashboardService::getOverview($clientId);

        require __DIR__ . '/../Views/dashboard/hosting.php';
    }
}
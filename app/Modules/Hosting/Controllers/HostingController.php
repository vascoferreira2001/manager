<?php

namespace App\Modules\Hosting\Controllers;

use App\Modules\Hosting\Repositories\HostingRepository;
use App\Modules\Provisioning\Drivers\PleskDriver;

class HostingController
{
    public function index()
    {
        $clientId = $_SESSION['user']['client_id'] ?? null;

        $hostings = HostingRepository::getClientHostings($clientId);

        require __DIR__ . '/../Views/index.php';
    }

    public function manage()
    {
        $id = $_GET['id'] ?? null;

        $hosting = HostingRepository::find($id);

        require __DIR__ . '/../Views/manage.php';
    }

    public function login()
    {
        $id = $_GET['id'] ?? null;

        $hosting = HostingRepository::find($id);

        $driver = new PleskDriver();

        $sso = $driver->generateSSO($hosting['domain']);

        header("Location: " . $sso['url']);
        exit;
    }
}
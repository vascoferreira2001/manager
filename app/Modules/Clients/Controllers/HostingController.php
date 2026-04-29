<?php

namespace App\Modules\Clients\Controllers;

use App\Core\Session;
use App\Repositories\HostingRepository;
use App\Modules\Provisioning\Drivers\PleskDriver;

class HostingController
{
    private HostingRepository $hosting;

    public function __construct()
    {
        $this->hosting = new HostingRepository();
    }

    private function clientId()
    {
        Session::start();

        $id = Session::get('client_id');

        if (!$id) {
            header("Location: /login");
            exit;
        }

        return $id;
    }

    public function manage()
    {
        $hosting = $this->hosting->findForClient($_GET['id'], $this->clientId());

        if (!$hosting) {
            die("Hosting não encontrado");
        }

        ob_start();
        require __DIR__ . '/../Views/dashboard/manage.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout.php';
    }

    public function loginToPlesk()
    {
        $hosting = $this->hosting->findForClient($_GET['id'], $this->clientId());

        $url = (new PleskDriver())->generateLoginUrl($hosting['domain']);

        header("Location: $url");
    }
}
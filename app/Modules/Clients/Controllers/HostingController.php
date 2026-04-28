<?php

namespace App\Modules\Clients\Controllers;

use App\Repositories\HostingRepository;
use App\Modules\Provisioning\Drivers\PleskDriver;

class HostingController
{
    private HostingRepository $hosting;

    public function __construct()
    {
        $this->hosting = new HostingRepository();
    }

    private function getClientId()
    {
        session_start();

        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }

        return $_SESSION['client_id'];
    }

    public function manage()
    {
        $clientId = $this->getClientId();
        $id = $_GET['id'] ?? null;

        $hosting = $this->hosting->findForClient($id, $clientId);

        if (!$hosting) {
            die("Hosting não encontrado");
        }

        ob_start();
        require __DIR__ . '/../Views/dashboard/manage.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout.php';
    }

    public function resetPassword()
    {
        $clientId = $this->getClientId();
        $id = $_POST['id'];

        $hosting = $this->hosting->findForClient($id, $clientId);

        if (!$hosting) {
            die("Hosting inválido");
        }

        $newPassword = bin2hex(random_bytes(6));

        $driver = new PleskDriver();
        $driver->changePassword($hosting['domain'], $newPassword);

        $this->hosting->updatePassword($id, $newPassword);

        header("Location: /dashboard/hosting/manage?id=" . $id);
    }

    public function suspend()
    {
        $clientId = $this->getClientId();
        $id = $_POST['id'];

        $hosting = $this->hosting->findForClient($id, $clientId);

        if (!$hosting) {
            die("Hosting inválido");
        }

        $driver = new PleskDriver();
        $driver->suspend($hosting['domain']);

        $this->hosting->updateStatus($id, 'suspended');

        header("Location: /dashboard/hosting");
    }

    public function unsuspend()
    {
        $clientId = $this->getClientId();
        $id = $_POST['id'];

        $hosting = $this->hosting->findForClient($id, $clientId);

        if (!$hosting) {
            die("Hosting inválido");
        }

        $driver = new PleskDriver();
        $driver->unsuspend($hosting['domain']);

        $this->hosting->updateStatus($id, 'active');

        header("Location: /dashboard/hosting");
    }

    public function loginToPlesk()
    {
        $clientId = $this->getClientId();
        $id = $_GET['id'];

        $hosting = $this->hosting->findForClient($id, $clientId);

        if (!$hosting) {
            die("Hosting não encontrado");
        }

        $driver = new PleskDriver();

        try {
            $url = $driver->generateLoginUrl($hosting['domain']);
            header("Location: " . $url);
            exit;
        } catch (\Exception $e) {
            die("Erro ao aceder ao Plesk");
        }
    }
}
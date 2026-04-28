<?php

namespace App\Repositories;

use App\Modules\Clients\Models\Hosting;

class HostingRepository
{
    private Hosting $model;

    public function __construct()
    {
        $this->model = new Hosting();
    }

    public function findForClient($id, $clientId)
    {
        return $this->model->findByIdAndClient($id, $clientId);
    }

    public function getClientHosting($clientId)
    {
        return $this->model->getByClient($clientId);
    }

    public function updatePassword($id, $password)
    {
        return $this->model->updatePassword($id, $password);
    }

    public function updateStatus($id, $status)
    {
        return $this->model->updateStatus($id, $status);
    }
}
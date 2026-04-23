<?php

namespace App\Controllers;

use System\Controller;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        print_r($clients);
    }

    public function create()
    {
        echo '<form method="POST" action="/clients/store">
                <input name="name" placeholder="Nome">
                <input name="email" placeholder="Email">
                <button type="submit">Guardar</button>
              </form>';
    }

    public function store()
    {
        Client::create($_POST);
        header("Location: /clients");
    }
}
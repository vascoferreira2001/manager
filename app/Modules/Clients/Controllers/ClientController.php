<?php

namespace App\Modules\Clients\Controllers;

use System\Controller;
use App\Modules\Auth\Middleware\AuthMiddleware;
use App\Models\Client;

class ClientController extends Controller
{
    public function __construct()
    {
        // Protege todas as ações deste controller
        AuthMiddleware::check();
    }

    /**
     * Lista de clientes
     */
    public function index()
    {
        $clients = Client::all();

        echo "<h2>Lista de Clientes</h2>";
        echo "<a href='/clients/create'>Novo Cliente</a><br><br>";

        foreach ($clients as $client) {
            echo "
                <div>
                    {$client['name']} ({$client['email']})
                    <a href='/clients/edit?id={$client['id']}'>Editar</a>
                    <a href='/clients/delete?id={$client['id']}'>Eliminar</a>
                </div>
            ";
        }
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        echo '
        <h2>Novo Cliente</h2>
        <form method="POST" action="/clients/store">
            <input name="name" placeholder="Nome" required>
            <input name="email" placeholder="Email" required>
            <button type="submit">Guardar</button>
        </form>
        ';
    }

    /**
     * Guardar cliente
     */
    public function store()
    {
        Client::create([
            'name' => $_POST['name'],
            'email' => $_POST['email']
        ]);

        header("Location: /clients");
        exit;
    }

    /**
     * Formulário de edição
     */
    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "ID inválido";
            return;
        }

        $client = Client::find($id);

        if (!$client) {
            echo "Cliente não encontrado";
            return;
        }

        echo "
        <h2>Editar Cliente</h2>
        <form method='POST' action='/clients/update'>
            <input type='hidden' name='id' value='{$client['id']}'>
            <input name='name' value='{$client['name']}' required>
            <input name='email' value='{$client['email']}' required>
            <button type='submit'>Atualizar</button>
        </form>
        ";
    }

    /**
     * Atualizar cliente
     */
    public function update()
    {
        Client::update($_POST['id'], [
            'name' => $_POST['name'],
            'email' => $_POST['email']
        ]);

        header("Location: /clients");
        exit;
    }

    /**
     * Eliminar cliente
     */
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            Client::delete($id);
        }

        header("Location: /clients");
        exit;
    }
}
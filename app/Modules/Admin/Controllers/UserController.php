<?php

namespace App\Modules\Admin\Controllers;

use System\Database;
use App\Modules\Auth\Middleware\AuthMiddleware;
use App\Models\Client;
use PDO;

class UserController
{
    public function __construct()
    {
        AuthMiddleware::check();
    }

    public function index()
    {
        $db = Database::connect();

        $users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>Utilizadores</h2>";
        echo "<a href='/admin/users/create'>Criar Utilizador</a><br><br>";

        foreach ($users as $user) {
            echo "
                <div>
                    {$user['name']} ({$user['email']})
                    <a href='/admin/users/edit?id={$user['id']}'>Editar</a>
                </div>
            ";
        }
    }

    public function create()
    {
        echo '
        <h2>Criar Utilizador</h2>
        <form method="POST" action="/admin/users/store">
            <input name="name" placeholder="Nome" required>
            <input name="email" placeholder="Email" required>
            <input name="password" type="password" placeholder="Password" required>

            <select name="role">
                <option value="admin">Admin</option>
                <option value="support-technical">Suporte Técnico</option>
                <option value="support-finance">Suporte Financeiro</option>
                <option value="support-client">Suporte Cliente</option>
                <option value="client">Cliente</option>
            </select>

            <button>Guardar</button>
        </form>
        ';
    }

    public function store()
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO users (name, email, password, role)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_BCRYPT),
            $_POST['role']
        ]);

        header("Location: /admin/users");
        exit;
    }

    public function edit()
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_GET['id']]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "
        <h2>Editar Utilizador</h2>
        <form method='POST' action='/admin/users/update'>
            <input type='hidden' name='id' value='{$user['id']}'>

            <input name='name' value='{$user['name']}'>

            <input name='email' value='{$user['email']}'>

            <button>Atualizar</button>
        </form>
        ";
    }

    public function update()
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            UPDATE users 
            SET name = ?, email = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['id']
        ]);

        header("Location: /admin/users");
        exit;
    }
}
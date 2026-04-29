<?php

use App\Modules\Home\Controllers\HomeController;
use App\Core\Security\Csrf;
use App\Core\View\View;
use App\Modules\Users\Models\User;

// Registar serviços básicos no container:
$container->set(View::class, fn() => new View());

// Exemplo: Home
$container->set(HomeController::class, fn() => new HomeController($container->get(View::class)));

// Rotas:
$router->get('/', [HomeController::class, 'index']);
$router->get('/health', fn($req, $res) => $res->json(['ok' => true, 'time' => date('c')]));


$router->get('/test-db', function($req, $res) {
    $u = new User();
    $u->fill([
        'name' => 'Admin',
        'email' => 'admin@local.test',
        'password' => password_hash('123456', PASSWORD_BCRYPT),
        'role' => 'admin'
    ]);
    $u->save();

    $found = User::find($u->id);
    $res->json(['created' => $u->toArray(), 'found' => $found?->toArray()]);
});
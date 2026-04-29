<?php

use App\Modules\Home\Controllers\HomeController;
use App\Core\Security\Csrf;
use App\Core\View\View;

// Registar serviços básicos no container:
$container->set(View::class, fn() => new View());

// Exemplo: Home
$container->set(HomeController::class, fn() => new HomeController($container->get(View::class)));

// Rotas:
$router->get('/', [HomeController::class, 'index']);
$router->get('/health', fn($req, $res) => $res->json(['ok' => true, 'time' => date('c')]));
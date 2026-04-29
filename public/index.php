<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/app/Core/Support/helpers.php';

use App\Core\Support\Env;
use App\Core\Support\ErrorHandler;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Http\Router;
use App\Core\Support\Container;
use App\Core\Support\Logger;
use App\Core\Security\Session;
use App\Core\Security\Csrf;


// 1) Load env
Env::load(dirname(__DIR__) . '/.env');

// 2) Error handling
ErrorHandler::register(config('app')['debug'] ?? false);

// 3) Boot container (very small)
$container = new Container();
$container->set(Logger::class, fn() => new Logger(base_path('storage/logs/app.log')));
$container->set(Session::class, fn() => new Session());
$container->set(Csrf::class, fn() => new Csrf($container->get(Session::class)));

// 4) Start session
$container->get(Session::class)->start();

// 5) Build request/response
$request = Request::capture();
$response = new Response();

// 6) Router + routes
$router = new Router($container, $request, $response);
require base_path('app/Config/routes.php');

// 7) Dispatch
$router->dispatch();
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
use App\Core\Database\Database;
use App\Core\Database\BaseModel;

// 1️⃣ Carregar variáveis de ambiente
Env::load(dirname(__DIR__) . '/.env');

if (!file_exists(base_path('storage/installed.lock'))) {
    if (!str_starts_with($_SERVER['REQUEST_URI'], '/install')) {
        header('Location: /install');
        exit;
    }
}

// 2️⃣ Error handler
ErrorHandler::register(config('app')['debug'] ?? false);

// 3️⃣ Criar container (AQUI)
$container = new Container();

// 4️⃣ Registar serviços base
$container->set(Logger::class, fn() =>
    new Logger(base_path('storage/logs/app.log'))
);

$container->set(Session::class, fn() =>
    new Session()
);

$container->set(Csrf::class, fn() =>
    new Csrf($container->get(Session::class))
);

// ✅ 5️⃣ REGISTAR DATABASE NO CONTAINER
$container->set(Database::class, fn() =>
    new Database(config('database'))
);

// ✅ 6️⃣ INJETAR DATABASE NO BaseModel (AQUI MESMO)
BaseModel::setDatabase(
    $container->get(Database::class)
);

// 7️⃣ Iniciar sessão
$container->get(Session::class)->start();

// 8️⃣ Criar Request / Response
$request  = Request::capture();
$response = new Response();

// 9️⃣ Criar Router
$router = new Router($container, $request, $response);

// 🔟 Carregar rotas
require base_path('app/Config/routes.php');

// 1️⃣1️⃣ Dispatch
$router->dispatch();
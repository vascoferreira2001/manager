<?php

require_once __DIR__ . '/../vendor/autoload.php';

use System\Router;

$router = new Router();

// Load routes
require_once __DIR__ . '/../config/routes.php';

// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI']);

require_once __DIR__ . '/../system/Bootstrap.php';
<?php
// public/index.php
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;

header('Content-Type: application/json; charset=utf-8');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$auth = new AuthController();

if ($uri === '/register' && $method === 'POST') {
    $auth->register();
    exit;
}

if ($uri === '/login' && $method === 'POST') {
    $auth->login();
    exit;
}

// fallback
http_response_code(404);
echo json_encode(['error' => 'Not Found']);

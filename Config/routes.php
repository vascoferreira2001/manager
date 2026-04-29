<?php

use System\Router;
use App\Modules\Auth\Middleware\AuthMiddleware;
use App\Modules\Auth\Middleware\PermissionMiddleware;

/** @var Router $router */

// Public
$router->get('/', 'HomeController@index');

$router->get('/login', 'Auth\AuthController@loginForm');
$router->post('/login', 'Auth\AuthController@login');
$router->get('/logout', 'Auth\AuthController@logout');

// 🔐 Dashboard protegido
$router->middleware('/dashboard', [
    \App\Modules\Auth\Middleware\AuthMiddleware::class
]);

$router->get('/dashboard', 'Clients\DashboardController@index');
$router->get('/dashboard/hosting', 'Clients\DashboardController@hosting');

// Hosting Management
$router->get('/dashboard/hosting/manage', 'Clients\HostingController@manage');
$router->post('/dashboard/hosting/reset-password', 'Clients\HostingController@resetPassword');
$router->post('/dashboard/hosting/suspend', 'Clients\HostingController@suspend');
$router->post('/dashboard/hosting/unsuspend', 'Clients\HostingController@unsuspend');
$router->get('/dashboard/hosting/login', 'Clients\HostingController@loginToPlesk');


<?php

use System\Router;
use App\Modules\Auth\Middleware\AuthMiddleware;

/** @var Router $router */

// PUBLIC
$router->get('/', 'HomeController@index');

$router->get('/login', 'Auth\AuthController@loginForm');
$router->post('/login', 'Auth\AuthController@login');
$router->get('/logout', 'Auth\AuthController@logout');


// =====================
// DASHBOARD
// =====================

$router->get('/dashboard', 'Clients\DashboardController@index');

$router->middleware('/dashboard', [
    AuthMiddleware::class
]);


// =====================
// HOSTING (CORE MODULE)
// =====================

$router->get('/hosting', 'Hosting\HostingController@index');
$router->get('/hosting/manage', 'Hosting\HostingController@manage');
$router->get('/hosting/login', 'Hosting\HostingController@login');

$router->post('/hosting/reset-password', 'Hosting\HostingController@resetPassword');
$router->post('/hosting/suspend', 'Hosting\HostingController@suspend');
$router->post('/hosting/unsuspend', 'Hosting\HostingController@unsuspend');

$router->middleware('/hosting', [AuthMiddleware::class]);
$router->middleware('/hosting/manage', [AuthMiddleware::class]);
$router->middleware('/hosting/login', [AuthMiddleware::class]);
$router->middleware('/hosting/reset-password', [AuthMiddleware::class]);
$router->middleware('/hosting/suspend', [AuthMiddleware::class]);
$router->middleware('/hosting/unsuspend', [AuthMiddleware::class]);
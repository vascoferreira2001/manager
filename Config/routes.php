<?php

use System\Router;
use App\Modules\Auth\Middleware\AuthMiddleware;
use App\Modules\Auth\Middleware\PermissionMiddleware;

/** @var Router $router */

// HOME
$router->get('/', 'HomeController@index');


// =====================
// CLIENTS
// =====================

$router->get('/clients', 'Clients\ClientController@index');
$router->get('/clients/create', 'Clients\ClientController@create');
$router->post('/clients/store', 'Clients\ClientController@store');

$router->get('/clients/edit', 'Clients\ClientController@edit');
$router->post('/clients/update', 'Clients\ClientController@update');

$router->get('/clients/delete', 'Clients\ClientController@delete');

// 🔐 Middleware Clients
$router->middleware('/clients', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'view_clients']
]);

$router->middleware('/clients/create', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'create_clients']
]);

$router->middleware('/clients/store', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'create_clients']
]);

$router->middleware('/clients/edit', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'edit_clients']
]);

$router->middleware('/clients/update', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'edit_clients']
]);

$router->middleware('/clients/delete', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'delete_clients']
]);


// =====================
// AUTH
// =====================

$router->get('/login', 'Auth\AuthController@loginForm');
$router->post('/login', 'Auth\AuthController@login');

// ⚠️ CORRIGIDO (tinhas errado)
$router->get('/2fa', 'Auth\AuthController@twoFAForm');
$router->post('/2fa', 'Auth\AuthController@verify2FA');

$router->get('/logout', 'Auth\AuthController@logout');


// =====================
// DASHBOARD
// =====================

$router->get('/dashboard', 'DashboardController@index');

$router->middleware('/dashboard', [
    AuthMiddleware::class
]);


// =====================
// PROFILE / 2FA
// =====================

// ⚠️ Ajusta se estiver dentro de Auth module
$router->get('/enable-2fa', 'Auth\ProfileController@enable2FA');
$router->post('/confirm-2fa', 'Auth\ProfileController@confirm2FA');

$router->middleware('/enable-2fa', [
    AuthMiddleware::class
]);

$router->middleware('/confirm-2fa', [
    AuthMiddleware::class
]);


// =====================
// ADMIN
// =====================

$router->get('/admin', 'Admin\DashboardController@index');

$router->get('/admin/users', 'Admin\UserController@index');
$router->get('/admin/users/create', 'Admin\UserController@create');
$router->post('/admin/users/store', 'Admin\UserController@store');

$router->get('/admin/users/edit', 'Admin\UserController@edit');
$router->post('/admin/users/update', 'Admin\UserController@update');

// 🔐 Middleware Admin (CRÍTICO)
$router->middleware('/admin', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'admin_access']
]);

$router->middleware('/admin/users', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'admin_access']
]);

$router->middleware('/admin/users/create', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'admin_access']
]);

$router->middleware('/admin/users/store', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'admin_access']
]);

$router->middleware('/admin/users/edit', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'admin_access']
]);

$router->middleware('/admin/users/update', [
    AuthMiddleware::class,
    [PermissionMiddleware::class, 'admin_access']
]);

use App\Modules\Billing\Controllers\InvoiceController;

$router->get('/invoices/create', 'Billing\InvoiceController@create');
$router->post('/invoices/store', 'Billing\InvoiceController@store');

$router->middleware('/invoices/create', [
    \App\Modules\Auth\Middleware\AuthMiddleware::class,
    [\App\Modules\Auth\Middleware\PermissionMiddleware::class, 'manage_invoices']
]);

$router->middleware('/invoices/store', [
    \App\Modules\Auth\Middleware\AuthMiddleware::class,
    [\App\Modules\Auth\Middleware\PermissionMiddleware::class, 'manage_invoices']
]);
<?php

use System\Router;

/** @var Router $router */

$router->get('/', 'HomeController@index');
$router->get('/clients', 'Clients\ClientController@index');
$router->get('/clients/create', 'Clients\ClientController@create');
$router->post('/clients/store', 'Clients\ClientController@store');


$router->get('/clients/edit', 'Clients\ClientController@edit');
$router->post('/clients/update', 'Clients\ClientController@update');

$router->get('/clients/delete', 'Clients\ClientController@delete');

$router->get('/login', 'Auth\AuthController@loginForm');
$router->post('/login', 'Auth\AuthController@login');

$router->get('/2fa', 'AuthController@twoFAForm');
$router->post('/2fa', 'AuthController@verify2FA');

$router->get('/logout', 'AuthController@logout');

$router->get('/dashboard', 'DashboardController@index');
$router->middleware('/dashboard', \App\Modules\Auth\Middleware\AuthMiddleware::class);

$router->get('/enable-2fa', 'ProfileController@enable2FA');
$router->post('/confirm-2fa', 'ProfileController@confirm2FA');

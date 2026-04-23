<?php

use System\Router;

/** @var Router $router */

$router->get('/', 'HomeController@index');
$router->get('/clients', 'ClientController@index');
$router->get('/clients/create', 'ClientController@create');
$router->post('/clients/store', 'ClientController@store');
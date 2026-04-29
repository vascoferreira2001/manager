<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Core/Support/helpers.php';

use App\Core\Support\Env;
use App\Core\Database\Database;
use App\Core\Database\Migrator;

// carregar env
Env::load(__DIR__ . '/../.env');

// criar db
$db = new Database(config('database'));

// correr migrator
$migrator = new Migrator($db, base_path('database/migrations'));
$migrator->migrate();
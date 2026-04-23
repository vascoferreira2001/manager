<?php

namespace System;

use PDO;

class Database
{
    private static $instance;

    public static function connect()
    {
        if (!self::$instance) {

            $config = require __DIR__ . '/../config/database.php';

            self::$instance = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                $config['user'],
                $config['pass']
            );

            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }
}
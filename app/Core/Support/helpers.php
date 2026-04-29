<?php

use App\Core\Support\Env;

function env(string $key, mixed $default = null): mixed
{
    return Env::get($key, $default);
}

function base_path(string $path = ''): string
{
    $root = dirname(__DIR__, 3); // project-root
    return $path ? $root . DIRECTORY_SEPARATOR . $path : $root;
}

function config(string $file): array
{
    $path = base_path("app/Config/{$file}.php");
    if (!is_file($path)) {
        return [];
    }
    return require $path;
}
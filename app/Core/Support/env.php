<?php

namespace App\Core\Support;

final class Env
{
    private static array $data = [];
    private static bool $loaded = false;

    public static function load(string $path): void
    {
        if (self::$loaded) return;
        self::$loaded = true;

        if (!is_file($path)) return;

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) continue;

            $parts = explode('=', $line, 2);
            $key = trim($parts[0] ?? '');
            $value = trim($parts[1] ?? '');

            $value = trim($value, "\"'");

            if ($key !== '') {
                self::$data[$key] = $value;
                $_ENV[$key] = $value;
            }
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::$data[$key] ?? $_ENV[$key] ?? $default;
    }
}
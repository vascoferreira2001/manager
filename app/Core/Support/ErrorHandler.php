<?php

namespace App\Core\Support;

final class ErrorHandler
{
    public static function register(bool $debug = false): void
    {
        ini_set('display_errors', $debug ? '1' : '0');
        error_reporting(E_ALL);

        set_exception_handler(function (\Throwable $e) use ($debug) {
            http_response_code(500);
            if ($debug) {
                echo "<h1>Erro</h1><pre>" . htmlspecialchars((string)$e) . "</pre>";
            } else {
                echo "Ocorreu um erro interno.";
            }
        });
    }
}
<?php

namespace System;

class Router
{
    private array $routes = [];
    private array $middlewares = []; 

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function middleware($uri, $middleware)
    {
        $this->middlewares[$uri] = (array) $middleware;
    }

    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($uri, PHP_URL_PATH);


        if (isset($this->middlewares[$uri])) {
            foreach ($this->middlewares[$uri] as $middleware) {
                $middleware::check();
            }
        }

        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        [$controllerPath, $method] = explode('@', $action);

    // Detecta se vem de módulo
        if (str_contains($controllerPath, '\\')) {

    // Ex: Auth\AuthController
        [$module, $controller] = explode('\\', $controllerPath);

        $controller = "App\\Modules\\$module\\Controllers\\$controller";

        } else {

    // Controllers globais (fallback)
        $controller = "App\\Controllers\\$controllerPath";
        }

        $instance = new $controller();

        call_user_func([$instance, $method]);
    }
}
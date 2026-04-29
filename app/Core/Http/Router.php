<?php

namespace App\Core\Http;

use App\Core\Support\Container;

final class Router
{
    private array $routes = [];
    private string $groupPrefix = '';
    private array $groupMiddleware = [];

    public function __construct(
        private Container $container,
        private Request $request,
        private Response $response
    ) {}

    public function get(string $path, array|callable $handler, array $middleware = []): void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array|callable $handler, array $middleware = []): void
    {
        $this->add('POST', $path, $handler, $middleware);
    }

    public function group(string $prefix, callable $callback, array $middleware = []): void
    {
        $prevPrefix = $this->groupPrefix;
        $prevMw = $this->groupMiddleware;

        $this->groupPrefix .= rtrim($prefix, '/');
        $this->groupMiddleware = array_merge($this->groupMiddleware, $middleware);

        $callback($this);

        $this->groupPrefix = $prevPrefix;
        $this->groupMiddleware = $prevMw;
    }

    private function add(string $method, string $path, array|callable $handler, array $middleware): void
    {
        $path = '/' . ltrim($path, '/');
        $fullPath = $this->groupPrefix . $path;
        $fullPath = rtrim($fullPath, '/') ?: '/';

        $this->routes[] = [
            'method' => $method,
            'path' => $fullPath,
            'handler' => $handler,
            'middleware' => array_merge($this->groupMiddleware, $middleware),
        ];
    }

    public function dispatch(): void
    {
        $reqPath = rtrim($this->request->uri, '/') ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $this->request->method) continue;

            $params = $this->match($route['path'], $reqPath);
            if ($params === null) continue;

            $pipeline = $this->buildPipeline($route['middleware'], function () use ($route, $params) {
                return $this->runHandler($route['handler'], $params);
            });

            $pipeline($this->request, $this->response);
            return;
        }

        $this->response->html('<h1>404</h1><p>Rota não encontrada.</p>', 404);
    }

    private function match(string $routePath, string $reqPath): ?array
    {
        // suporta /clients/{id}
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $reqPath, $matches)) return null;

        $params = [];
        foreach ($matches as $k => $v) {
            if (!is_string($k)) continue;
            $params[$k] = $v;
        }
        return $params;
    }

    private function buildPipeline(array $middleware, callable $last): callable
    {
        $next = $last;

        for ($i = count($middleware) - 1; $i >= 0; $i--) {
            $mwClass = $middleware[$i];
            $next = function (Request $req, Response $res) use ($mwClass, $next) {
                $mw = $this->container->get($mwClass);
                return $mw->handle($req, $res, fn() => $next($req, $res));
            };
        }

        return fn(Request $req, Response $res) => $next($req, $res);
    }

    private function runHandler(array|callable $handler, array $params): mixed
    {
        if (is_callable($handler)) {
            return $handler($this->request, $this->response, $params);
        }

        // [ControllerClass, 'method']
        [$class, $method] = $handler;
        $controller = $this->container->get($class);
        return $controller->{$method}($this->request, $this->response, $params);
    }
}
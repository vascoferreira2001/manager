<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;
use App\Core\Http\Response;

interface MiddlewareInterface
{
    public function handle(Request $request, Response $response, callable $next): mixed;
}
<?php

namespace App\Core\Http;

use App\Core\View\View;

abstract class Controller
{
    public function __construct(protected View $view) {}

    protected function view(Response $response, string $view, array $data = [], int $status = 200): void
    {
        $html = $this->view->render($view, $data);
        $response->html($html, $status);
    }

    protected function json(Response $response, array $data, int $status = 200): void
    {
        $response->json($data, $status);
    }
}
<?php

namespace App\Core\View;

final class View
{
    public function render(string $view, array $data = []): string
    {
        $path = base_path('app/' . str_replace('.', '/', $view) . '.php');
        if (!is_file($path)) {
            throw new \RuntimeException("View não encontrada: {$path}");
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $path;
        return ob_get_clean();
    }
}
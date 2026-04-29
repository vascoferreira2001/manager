<?php

namespace System;

class Controller
{
    protected function view($path, $data = [])
    {
        extract($data);

        ob_start();
        require $path;
        $content = ob_get_clean();

        require __DIR__ . '/../app/Views/layouts/base.php';
    }
}
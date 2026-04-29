<?php

namespace App\Installer\Controllers;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Http\Controller;
use App\Core\Support\Container;

final class InstallController extends Controller
{
    public function __construct(private Container $container)
    {
        parent::__construct($container->get(\App\Core\View\View::class));
    }

    /**
     * Step 1 – verificar requisitos
     */
    public function requirements(Request $request, Response $response): void
    {
        $this->view($response, 'Installer.Views.step1_requirements', [
            'php_version' => PHP_VERSION,
            'extensions' => [
                'pdo' => extension_loaded('pdo'),
                'pdo_mysql' => extension_loaded('pdo_mysql'),
                'openssl' => extension_loaded('openssl'),
            ],
        ]);
    }

    /**
     * Step 2 – configurar base de dados (placeholder)
     */
    public function database(Request $request, Response $response): void
    {
        $response->html('<h1>DB step (a implementar)</h1>');
    }

    /**
     * Step 3 – correr migrations (placeholder)
     */
    public function migrate(Request $request, Response $response): void
    {
        $response->html('<h1>Migrations step (a implementar)</h1>');
    }

    /**
     * Step 4 – criar admin (placeholder)
     */
    public function admin(Request $request, Response $response): void
    {
        $response->html('<h1>Admin step (a implementar)</h1>');
    }
}
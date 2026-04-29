<?php

namespace App\Modules\Home\Controllers;

use App\Core\Http\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;

final class HomeController extends Controller
{
    public function index(Request $request, Response $response): void
    {
        $this->view($response, 'Modules.Home.Views.index', [
            'title' => 'WHMS Core (v0) - OK',
        ]);
    }
}
<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReportsController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function today(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'admin/orderIndexView.php');
    }

    public function allTime(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'admin/orderShowView.php');
    }

    public function adminReportsView(Request $request, Response $response, array $args): Response
    {
        $data = [""];
        return $this->render($response, 'admin/adminReportsView.php', $data);
    }
}

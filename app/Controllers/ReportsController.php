<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\UserContext;
use App\Domain\Models\KpiModel;
use App\Helpers\Core\PDOService;


class ReportsController extends BaseController
{
    public function __construct(Container $container, private KpiModel $kpiModel)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $today = date('Y-m-d');
        $data = [
            'page_title' => 'Welcome to KVC Manager',
            'contentView' => APP_VIEWS_PATH . '/pages/reportsView.php',
            'isSideBarShown' => true,
            'isAdmin' => UserContext::isAdmin(),
            'data' => [
                'title' => 'Reports',
                'message' => 'Reports Page',
            ]
        ];

        return $this->render($response, 'common/layout.php', $data);
    }

    public function today(Request $request, Response $response, array $args): Response

    {
        return $this->render($response, 'admin/orderIndexView.php');
    }

    public function allTime(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'admin/orderShowView.php');
    }


    public function error(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'errorView.php');
    }
}

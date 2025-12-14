<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\UserContext;


class ReportsController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $data = [
            'page_title' => 'Welcome to KVC Manager',
            'contentView' => APP_VIEWS_PATH . '\admin\reportsView.php',
            'isSideBarShown' => true,
            'isAdmin' => UserContext::isAdmin(),
            'data' => [
                'title' => 'Reports',
                'message' => 'Reports Page',
            ],
        ];

        // 'data' => $this->adminDataHelper->adminPageData(),

        return $this->render($response, 'common/layout.php', $data);
    }

/*
    public function __construct(Container $container,
    private AdminDataHelper $adminDataHelper
    )
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $data = [
            'title' => "Admin",
            'message' => "Welcome to the admin page",
            'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
            'isSideBarShown' => true,
            'isAdmin' => UserContext::isAdmin(),
            'data' => $this->adminDataHelper->adminPageData(),
        ];

        return $this->render($response, 'admin/databaseView.php', $data);
    }
*/

    public function today(Request $request, Response $response, array $args): Response


    {
        return $this->render($response, 'admin/orderIndexView.php');
    }

    public function allTime(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'admin/allTimeReportsView.php');
    }


    public function error(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'errorView.php');
    }
}


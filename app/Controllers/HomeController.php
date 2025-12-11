<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Domain\Models\UserModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends BaseController
{
    //NOTE: Passing the entire container violates the Dependency Inversion Principle and creates a service locator anti-pattern.
    // However, it is a simple and effective way to pass the container to the controller given the small scope of the application and the fact that this application is to be used in a classroom setting where students are not yet familiar with the Dependency Inversion Principle.

    public function __construct(
        Container $container,
    private UserModel $userModel)
        {
        parent:: __construct($container);
        }

    public function index(Request $request, Response $response, array $args): Response
    {
        $data = $this->userModel->getTeamMembersByStation(2);

        $data = [
            'page_title' => 'Welcome to KVC Manager',
            'contentView' => APP_VIEWS_PATH . '/pages/homeView.php',
            'isSideBarShown' => true,
            'data' => [
                'title' => 'Home',
                'message' => $data,
            ]
        ];

        //dd($data);
        //var_dump($this->session); exit;
        return $this->render($response, 'admin/dashboardView.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'errorView.php');
    }
}

<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\PalletModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductModel;

class AuthController extends BaseController
{
    public function __construct(
        Container $container,
    private PalletModel $palletModel)
    {
        parent:: __construct($container);
    }

    public function showLoginForm(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderIndexView.php');
    }

    public function login(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderShowView.php');
    }

    public function showRegisterForm(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    public function register(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    public function showTwoFactorForm(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    public function verifyTwoFactor(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    public function logout(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryIndexView.php');
    }
}

?>

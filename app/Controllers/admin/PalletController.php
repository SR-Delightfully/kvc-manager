<?php

declare(strict_types=1);

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Domain\Models\PalletModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductModel;
use App\Helpers\UserContext;

class PalletController extends BaseController
{
    public function __construct(
        Container $container,
    private PalletModel $palletModel)
    {
        parent:: __construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response {
        $pallets = $this->palletModel->getAllPalletsSimple();

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/admin/pallets.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'data' => [
                    'title' => 'Admin Pallets',
                    'pallets' => $pallets,
                ]
            ];

        return $this->render($response, 'admin/palletIndexView.php');
    }

    public function show(Request $request, Response $response, array $args): Response {
        $palletId = $args['id'];
        $pallet = $this->palletModel->getPalletCompleteById($palletId);

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/admin/pallets.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'data' => [
                    'title' => 'Admin Pallets',
                    'pallet' => $pallet,
                ]
            ];

        return $this->render($response, 'admin/orderShowView.php');
    }

    //probably useless
    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }
    //probably useless
    public function store(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    public function edit(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    public function update(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryEditView.php');
    }

    //probably useless
    public function delete(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryIndexView.php');
    }
}

?>

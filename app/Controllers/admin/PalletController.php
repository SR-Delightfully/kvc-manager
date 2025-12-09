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
use App\Helpers\AdminDataHelper;
use App\Helpers\FlashMessage;

class PalletController extends BaseController
{
    public function __construct(
        Container $container,
    private PalletModel $palletModel, private AdminDataHelper $adminDataHelper)
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
        $pallet_id = $args['id'];

        $pallet = $this->palletModel->getPalletCompleteById($pallet_id);

        $data = [
                'page_title' => 'Welcome to KVC Manager',
                'contentView' => APP_VIEWS_PATH . '/pages/admin/colours.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_pallet_edit' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['pallet_to_edit' => $pallet]),
            ];
        return $this->render($response, 'admin/databaseView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['start_time']  || $data['end_time'] || $data['units'])) {
            $errors[] = "Fill out start_time, end_time and units fields";
        }

        if (!is_numeric($data['units'])) {
            $errors[] = "Units must be a number";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->palletModel->updatePalletize($data['pallet_id'], $data);
            FlashMessage::success("Successfully updated colour");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Insert failed. Please try again");
            return $this->render($response, 'admin/databaseView.php');
        }
    }

    //probably useless
    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->palletModel->delete($id);
        FlashMessage::success("Successfully Deleted Pallet With ID: $id");

        return $this->redirect($request, $response, 'admin.index');
    }

    public function showDelete(Request $request, Response $response, array $args): Response {
        $pallet_id = $args['id'];

        $variant = $this->palletModel->getPalletCompleteById($pallet_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_pallet_delete' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['pallet_to_delete' => $variant,]),
            ];
        return $this->render($response, 'admin/databaseView.php', $data);
    }
}

?>

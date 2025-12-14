<?php

declare(strict_types=1);

namespace App\Controllers\admin;
use App\Controllers\BaseController;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ProductModel;
use App\Domain\Models\StationModel;
use App\Helpers\AdminDataHelper;
use App\Helpers\UserContext;
use App\Helpers\FlashMessage;

class StationController extends BaseController
{
    public function __construct(
        Container $container,
        private AdminDataHelper $adminDataHelper,
    private StationModel $stationModel)
    {
        parent:: __construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderIndexView.php');
    }

    public function show(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/orderShowView.php');
    }

    public function create(Request $request, Response $response, array $args): Response {
        return $this->render($response, 'admin/categoryCreateView.php');
    }

    public function store(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['station_name'])) {
            $errors[] = "Station name is required";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->stationModel->createStation($data);
            FlashMessage::success("Successfully created station");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Insert failed. Please try again");
            return $this->render($response, 'admin/databaseView.php');
        }
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $product_id = $args['id'];

        $product = $this->stationModel->getStationById($product_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_station_edit' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['station_to_edit' => $product]),
            ];
        return $this->render($response, 'common/layout.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();
        $errors = [];

        if (empty($data['station_name'])) {
            $errors[] = "Station name must be filled out";
        }

        if (!empty($errors)) {
            FlashMessage::error($errors[0]);
            return $this->redirect($request, $response, 'admin.index');
        }
        try {
            $this->stationModel->updateStation($data['station_id'], $data);
            FlashMessage::success("Successfully updated station");
            return $this->redirect($request, $response, 'admin.index');
        } catch (\Throwable $th) {
            FlashMessage::error("Update failed. Please try again");
            return $this->redirect($request, $response, 'admin.index');
        }
    }

    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->stationModel->deleteStation($id);
        FlashMessage::success("Successfully Deleted Station With ID: $id");

        return $this->redirect($request, $response, 'admin.index');
    }

    public function showDelete(Request $request, Response $response, array $args): Response {
        $station_id = $args['id'];

        $station = $this->stationModel->getStationById($station_id);

        $data = [
                'contentView' => APP_VIEWS_PATH . '/pages/adminView.php',
                'isSideBarShown' => true,
                'isAdmin' => UserContext::isAdmin(),
                'show_station_delete' => true,
                'data' => array_merge($this->adminDataHelper->adminPageData(),
                        ['station_to_delete' => $station,]),
            ];
        return $this->render($response, 'common/layout.php', $data);
    }
}

?>

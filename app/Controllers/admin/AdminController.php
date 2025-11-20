<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Models\ColourModel;
use App\Domain\Models\PalletModel;
use App\Domain\Models\UserModel;
use App\Domain\Models\ProductModel;
use App\Domain\Models\ProductVariantModel;
use App\Domain\Models\ScheduleModel;
use App\Domain\Models\StationModel;
use App\Domain\Models\ShiftModel;
use App\Domain\Models\TeamModel;


class AdminController extends BaseController
{
    public function __construct(Container $container,
    private ColourModel $colourModel,
    private PalletModel $palletModel,
    private UserModel $userModel,
    private ProductModel $productModel,
    private ProductVariantModel $productVariantModel,
    private ScheduleModel $scheduleModel,
    private StationModel $stationModel,
    private ShiftModel $shiftModel,
    private TeamModel $teamModel)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $data = [
            'title' => "Admin",
            'message' => "Welcome to the admin page",
            'products' => $this->productModel->getAllProducts(),
            'product_types' => $this->productModel->getAllProductTypes(),
            'colours' => $this->colourModel->getAllColours(),
            'variants' => $this->productVariantModel->getAllVariants(),
            'users' => $this->userModel->getAllUsers(),
            'schedules' => $this->scheduleModel->getAllSchedules(),
            'shifts' => $this->shiftModel->getAllShifts(),
            'stations' => $this->stationModel->getAllStations(),
            'pallets' => $this->palletModel->getAllPalletsComplete(),
            'teams' => $this->teamModel->getAllTeams(),
        ];

        return $this->render($response, 'pages/adminView.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'errorView.php');
    }
}

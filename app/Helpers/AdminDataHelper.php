<?php
namespace App\Helpers;

use App\Domain\Models\ProductModel;
use App\Domain\Models\ColourModel;
use App\Domain\Models\ProductVariantModel;
use App\Domain\Models\UserModel;
use App\Domain\Models\ScheduleModel;
use App\Domain\Models\ShiftModel;
use App\Domain\Models\StationModel;
use App\Domain\Models\PalletModel;
use App\Domain\Models\TeamModel;



class AdminDataHelper
{

    public function __construct(
        private ProductModel $productModel,
        private ColourModel $colourModel,
        private ProductVariantModel $productVariantModel,
        private UserModel $userModel,
        private ScheduleModel $scheduleModel,
        private ShiftModel $shiftModel,
        private StationModel $stationModel,
        private PalletModel $palletModel,
        private TeamModel $teamModel
    )
    {}

    public function adminPageData(): ?array {
        return [
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
    }
}
?>

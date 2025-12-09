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
use App\Domain\Models\ToteModel;


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
        private TeamModel $teamModel,
        private ToteModel $toteModel
    )
    {}

    public function adminPageData(): ?array {
        return [
            'products' => $this->productModel->getAllProductsClean(),
            'product_types' => $this->productModel->getAllProductTypes(),
            'colours' => $this->colourModel->getAllColours(),
            'variants' => $this->productVariantModel->getAllVariantsClean(),
            'users' => $this->userModel->getUsers(),
            'schedules' => $this->scheduleModel->getAllSchedules(),
            'shifts' => $this->shiftModel->getAllShifts(),
            'stations' => $this->stationModel->getAllStations(),
            'pallets' => $this->palletModel->getAllPalletsClean(),
            'teams' => $this->teamModel->getAllTeamsClean(),
            'team_members' => $this->teamModel->getAllTeamMembersClean(),
            'totes' => $this->toteModel->getAllTotesClean(),
        ];
    }
}
?>

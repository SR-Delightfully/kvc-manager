<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class StationModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }
    public function getAllStations(): void {

    }

    public function createStation(array $data): void {

    }

    public function deleteStation(int $stationId){

    }
}

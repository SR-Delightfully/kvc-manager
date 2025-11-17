<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class StationModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }
    public function getStationById($id): ?array {
        $stmt = "SELECT * FROM station WHERE station_id = :id";
        $params = [':id'=>$id];
        $station = $this->selectOne($stmt,$params);
        return $station;
    }
    public function getAllStations(): ?array {
        $stmt = "SELECT * FROM station";
        $stations = $this->selectAll($stmt);
        return $stations;
    }

    public function createStation(array $data): void {
        $stmt = "INSERT INTO station(station_description) VALUES
        (:station_desc)";
        $params = [':station_desc'=>$data['station_description']];
        $this->execute($stmt, $params);
    }

    public function deleteStation(int $id){
        $stmt = "DELETE FROM station WHERE station_id = :id";
        $params = ['id'=>$id];
        $this->execute($stmt,$params);
    }

    public function updateStation($id, $data) {
        $stmt = "UPDATE station SET
                    station_description = :sDesc,
                    WHERE station_id = :id";

        $params = [':sDesc'=>$data['station_description']];
        $this->execute($stmt,$params);
    }
}

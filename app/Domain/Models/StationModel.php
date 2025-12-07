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

    public function getStationByUserId($userId): ?array {
        $stmt = "SELECT s.* FROM station s
                 JOIN team t ON s.station_id = t.station_id
                 JOIN team_members tm ON t.team_id = tm.team_id
                 WHERE tm.user_id = :user_id";
        $params = [':user_id' => $userId];
        $station = $this->selectOne($stmt, $params);
        return $station;
    }

    public function createStation(array $data): void {
        $stmt = "INSERT INTO station(station_name) VALUES
        (:station_desc)";
        $params = [':station_desc'=>$data['station_name']];
        $this->execute($stmt, $params);
    }

    public function deleteStation($id){
        $stmt = "DELETE FROM station WHERE station_id = :id";
        $params = ['id'=>$id];
        $this->execute($stmt,$params);
    }

    public function updateStation($id, $data) {
        $stmt = "UPDATE station SET
                    station_name = :sName
                    WHERE station_id = :id";

        $params = [':sName'=>$data['station_name'], ':id' => $id];
        $this->execute($stmt,$params);
    }
}

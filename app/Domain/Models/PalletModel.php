<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class PalletModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    public function getPalletCompleteById($id){
        $stmt = "SELECT pallet.*, palletize_session.* FROM pallet LEFT JOIN palletize_session ON pallet.pallet_id =  palletize_session.pallet_id WHERE pallet.pallet_id = :id";
        $params = [':id'=>$id];
        $pallet = $this->selectOne($stmt,$params);
        return $pallet;
    }

    public function getAllPalletsComplete(): ?array {
        $stmt = "SELECT pallet.*, palletize_session.* FROM pallet LEFT JOIN palletize_session ON pallet.pallet_id =  palletize_session.pallet_id";
        $pallets = $this->selectAll($stmt);
        return $pallets;
    }

    public function getAllPalletsSimple(): ?array {
        $stmt = "SELECT * FROM pallet";
        $pallets = $this->selectAll($stmt);
        return $pallets;
    }

    public function insertPalletizeSession(int $pallet_id, String $start_time, String $end_time,int $units, bool $breaks, int $break_time, bool $mess, String $notes) : int
    {
        //? 1) Sanitize Data and convert

        //? 2) Insert
        $sql = "INSERT INTO palletize_session(pallet_id, start_time, end_time, units, breaks, break_time, mess, notes) VALUE(
        :pallet_id,
        :start_time,
        :end_time, units,
        :breaks,
        :break_time,
        :mess,
        :notes)";

        //? 3) Execute
        $this->execute($sql, [
        "pallet_id" => $pallet_id,
        "start_time" => $start_time,
        "end_time" => $end_time,
        "units" => $units,
        "breaks"=> $breaks,
        "break_time" => $break_time,
        "mess" => $mess,
        "notes"=> $notes
        ]);

        //? 4) return row id
        return (int)$this->lastInsertId() ;
    }
}

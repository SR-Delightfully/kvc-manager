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
}

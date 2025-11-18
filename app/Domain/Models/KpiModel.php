<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class KpiModel extends BaseModel
{
        public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    /**
     * The function scans the progress of all teams and it
     *  returns an array that represents the leaderboard of th teams, from best to worst performance. The performance is based on units produced per minute on average.
     * The calculation only takes into account the records that match the input dates
     * @return array the array's first index is to the most performant team and so on.
     *
     */
    public function getTeamLeaderboard($start, $end)
    {
        $stmt = "SELECT pallet.*, palletize_session.* FROM pallet LEFT JOIN palletize_session ON pallet.pallet_id =  palletize_session.pallet_id WHERE pallet.pallet_id = :id";
        $params = [':id'=>$id];
        $pallet = $this->selectOne($stmt,$params);
        return [];
    }
}

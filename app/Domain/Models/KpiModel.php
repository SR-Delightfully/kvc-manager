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
     * The calculation only takes into account the records that match the input dates     *
     * @param mixed $startDate start date to start calculations
     * @param mixed $endDate date of the last calculations
     * @return array the array's first index is to the most performant team and so on.
     */
    public function getTeamLeaderboard($startDate, $endDate) : array
    {
        //? 1) Find all pelletize sessions in the date range
        //? 2) Calculate the units/minute worked for every fund session
        //? 3) Calculate the avg for the team
        //? 4) Compare and sort
        //? 5) return the result array

        $stmt = "SELECT ";
        // $params = [':id'=>$id];
        // $sessions = $this->selectOne($stmt,$params);
        return [];
    }

    //! teams have names or colors or just ID? Maybe update the db to add team names/color codes

    /**
     * Calculates a team's performance by
     * @param mixed $teamId
     * @param mixed $startDate
     * @param mixed $endDate
     * @return array
     */
    public function getTeamPerformance($teamId, $startDate, $endDate) : array
    {
        //? 1) Get all the pelletize sessions of the team
        //? 2) Filter only the sessions from the time frame
        //? 3) Get the productivity of each session (units produced per minute)
        //? 4) Place the results in an array in chronological order

        return [];
    }

    /**
     * Summary of getTeamDailyProduction
     * @param mixed $teamId
     * @param mixed $date by default, it's the current time.
     * @return int total units produced that day  y the team
     */
    public function getTeamDailyProduction($teamId, $date = date('Y-m-d H:i:s')) : int
    {
        //? 1) Find the team
        //? 2) Count all the units produced that day
        //? 3)
        //? 4)

        return 300;
    }
}


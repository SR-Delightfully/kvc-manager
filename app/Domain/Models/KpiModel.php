<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class KpiModel extends BaseModel
{
    public function __construct(PDOService $pDOService)
    {
        parent::__construct($pDOService);
    }


    /**
     * The function scans the progress of all teams and it
     *  returns an array that represents the leaderboard of th teams, from best to worst performance. The performance is based on units produced per minute on average.
     * The calculation only takes into account the records that match the input dates     *
     * @param mixed $startDate start date to start calculations
     * @param mixed $endDate date of the last calculations
     * @return array the array's first index is to the most performant team and so on.
     */
    public function getTeamAvgProductionRate($startDate, $endDate): array
    {
        //? 0) Validate input

        //? 1) Find all pelletize sessions in the date range

        $sql = "SELECT * FROM palletize_session
        WHERE start_time BETWEEN :start AND :end";
        $sessions = $this->selectAll($sql, ["start" => $startDate, "end" => $endDate]);

        //? 2) Calculate the units/minute worked for every found session
        $teamPerformance = [];

        foreach ($sessions as $session) {
            $sql2 = "SELECT * FROM palletize_session WHERE session_id = :id";

            //sessions still ongoing won't have units set, so skip those:
            $units = $session["units"];
            if ($units == null || $units <= 0) {
                continue;
            }
            $this->selectOne($sql2, ["id" => $session["session_id"]]);
        }

        //? 3) Calculate the avg for the team
        //? 4) Compare and sort
        //? 5) return the result array

        $stmt = "SELECT ";
        // $params = [':id'=>$id];
        // $sessions = $this->selectOne($stmt,$params);
        return [];
    }

    //! Compare the highest % above the median time it takes to complete a pallet of that same product variant.
    public function getTeamLeaderboard($startDate, $endDate, $variant_id): array
    {
        $leaderBoard = [];

        //? 0) Validate input
        //? 1) Find all pelletize sessions in the date range
        // $allSessionsSql = "SELECT * FROM palletize_session BETWEEN :start AND :end";
        // $allSessions = $this->selectAll($allSessionsSql, ["start" => $startDate, "end" => $endDate, "variantId" => $variant_id]);

        // foreach ($allSessions as $key => $session) {
        //     $session['duration'] = $this->getSessionDurationMins($session['session_id']);
        // }

        // $sql = "SELECT t.variant_id, TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time), ps.units
        // FROM palletize_session ps
        // JOIN pallet p ON ps.pallet_id = p.pallet_id
        // JOIN tote t ON t.tote_id = p.tote_id
        // WHERE ps.start_time BETWEEN '2021/02/25' AND CURRENT_TIMESTAMP
        // -- GROUP BY ps.pallet_id
        // ORDER BY ps.start_time ASC";
        $sql = "SELECT t.variant_id, TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time), ps.units
        FROM palletize_session ps
        JOIN pallet p ON ps.pallet_id = p.pallet_id
        JOIN tote t ON t.tote_id = p.tote_id
        WHERE ps.start_time BETWEEN :start AND :end
        ORDER BY ps.start_time ASC";

        $sessions = $this->selectAll($sql, ["start" => $startDate, "end" => $endDate]);

        //? 3) Find the median for every pallet variant (pv)

        //? 4) Find the difference from median of the pv of every palletize session in %

        //? 4.5) Filter out those <= median

        //? 5) Get the teams that have the highest +% found (10 best above median)
        return $leaderBoard;
    }
    //  (CONVERT(datetime, '18-06-12 10:34:09 PM', 5));
    public function getSessionDurationMins(int $session_id)
    {
        $sql = "SELECT TIMESTAMPDIFF(MINUTE, start_time, end_time) FROM palletize_session WHERE session_id = :id";

        return $this->selectOne($sql, ["id" => $session_id]);
    }


    /**
     * Calculates a team's performance  (units/minute)
     * @param mixed $teamId
     * @param mixed $startDate
     * @param mixed $endDate
     * @return array of the team's performance by how much units they produce a minute
     */
    public function getTeamProgress($team_id, $startDate, $endDate): array
    {
        $progress = []; //Chronological

        $sql = "SELECT TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time) as duration, ps.units, t.team_id
        FROM palletize_session ps
        JOIN pallet p ON p.pallet_id = ps.pallet_id
        JOIN team t ON p.station_id = t.station_id
        WHERE ps.start_time BETWEEN :start AND :end
        AND ps.pallet_id = :team
        ORDER BY ps.start_time ASC";

        $sessions = $this->selectAll($sql, ["team"=>$team_id, "start" => $startDate, "end" => $endDate]);

        foreach ($sessions as $key => $session) {
            $units = $session['units'];
            $duration = $session['duration'];

            if($units > 0 && $duration > 0) {
                $progress[] = $units / $duration;
            }
        }
        return $progress;
    }

    public function getStationProgress($pallet_id, $startDate, $endDate): array
    {
        $progress = []; //Chronological

        $sql = "SELECT TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time) as duration, ps.units
        FROM palletize_session ps
        JOIN pallet p ON p.pallet_id = ps.pallet_id
        WHERE ps.start_time BETWEEN :start AND :end
        AND ps.pallet_id = :pId
        ORDER BY ps.start_time ASC";

        $sessions = $this->selectAll($sql, ["pId"=>$pallet_id, "start" => $startDate, "end" => $endDate]);

        foreach ($sessions as $key => $session) {
            $units = $session['units'];
            $duration = $session['duration'];

            if($units > 0 && $duration > 0) {
                $progress[] = $units / $duration;
            }
        }
        return $progress;
    }

    /**
     * Summary of getTeamDailyProduction
     * @param mixed $teamId
     * @param mixed $date by default, it's the current time.
     * @return int total units produced that day  y the team
     */
    public function getTeamDailyProduction($teamId, $date = date('Y-m-d H:i:s')): int
    {
        //? 1) Find the team
        //? 2) Count all the units produced that day
        //? 3)
        //? 4)

        return 300;
    }
}

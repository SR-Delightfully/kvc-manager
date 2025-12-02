<?php

namespace App\Domain\Models;
use App\Helpers\Core\PDOService;
class KpiModel extends BaseModel
{
    public function __construct(PDOService $pDOService)
    {
        parent::__construct($pDOService);
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
        WHERE t.team_id = :team
        AND ps.start_time BETWEEN :start AND :end
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


        /**
         * Gets the average
         *
         * @param [type] $startDate
         * @param [type] $endDate
         * @return array
         */
        public function getTeamsAvgProgress($startDate, $endDate): array
        {

            $teamsProgress = [];

            $teamsSql = "SELECT team_id, station_id FROM team";
            $teams = $this->selectAll($teamsSql);

            foreach($teams as  $team) {

                $team_id = $team['team_id'];

                $oneProgress = $this->getTeamProgress($team_id, $startDate, $endDate);
                $progressSize = count($oneProgress);

                if($progressSize > 0) {
                    $teamsProgress[$team_id] = array_sum($oneProgress) / $progressSize;
                }
            }

            // Example output:
            // $WE = [
            //     team_id => 23.1,
            //     2 => 18.1
            // ];

            return $teamsProgress;

        }


    public function getStationPerformance($stationId, $startDate, $endDate): array
    {
        $progress = []; //Chronological

        $sql = "SELECT TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time) as duration, ps.units
        FROM palletize_session ps
        JOIN pallet p ON p.pallet_id = ps.pallet_id
        WHERE ps.start_time BETWEEN :start AND :end
        AND p.station_id = :stationId
        ORDER BY ps.start_time ASC";

        $sessions = $this->selectAll($sql, ["stationId"=>$stationId, "start" => $startDate, "end" => $endDate]);

        foreach ($sessions as $key => $session) {
            $units = $session['units'];
            $duration = $session['duration'];

            if($units > 0 && $duration > 0) {
                $progress[] = $units / $duration;
            }
        }
        return $progress; //in chronological order
    }

    /**
     * Summary of getTeamDailyProduction
     * @param mixed $teamId
     * @param mixed $date by default, it's the current time.
     * @return array total units produced that day by the team, or empty for invalid date
     */
    public function getTeamDailyProduction($teamId, $date = null): array
    {
        if($date == null) {
            return [];
        }

        $start = $date.' 00:00:00';
        $end = $date.' 23:59:59';

        return $this->getTeamProgress($teamId, $start, $end);
    }

    // public function getA()
    // {

    // }
}


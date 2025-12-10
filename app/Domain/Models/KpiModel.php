<?php
namespace App\Domain\Models;
use App\Helpers\Core\PDOService;

class KpiModel extends BaseModel

{
    /**
     * Undocumented function
     *
     * @param PDOService $pDOService
     */
    public function __construct(PDOService $pDOService)
    {
        parent::__construct($pDOService);
    }

    /**
     * Undocumented function
     *
     * @param [type] $startDate
     * @param [type] $endDate
     * @param [type] $variant_id
     * @return array
     */
    //! Compare the highest % above the median time it takes to complete a pallet of that same product variant.
    // public function getTeamLeaderboard($startDate, $endDate, $variant_id): array
    // {
    //      $leaderBoard = [];
    //     $sql = "SELECT t.team_id, t.variant_id, TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time) as duration, ps.units
    //     FROM palletize_session ps
    //     JOIN pallet p ON ps.pallet_id = p.pallet_id
    //     JOIN tote t ON t.tote_id = p.tote_id
    //     WHERE ps.start_time BETWEEN '2021/02/25' AND CURRENT_TIMESTAMP
    //     ORDER BY ps.start_time ASC";
    //     $sql = "SELECT t.variant_id, TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time), ps.units
    //     FROM palletize_session ps
    //     JOIN pallet p ON ps.pallet _id = p.pallet_id
    //     JOIN tote t ON t.tote_id =  p.tote_id
    //     WHERE t.variant_id = :variant
    //     AND ps.start_time BETWEEN :start AND :end
    //     ORDER BY ps.start_time ASC";


    //     $sessions  = $this->selectAll($sql, ["variant" => $variant_id, "start" => $startDate, "end" => $endDate]);
    //     if(empty($sessions))
    //     {
    //         return  [];
    //     }

    //     //?3) Find the median for every pallet variant (pv)


     //     //? 4) Find the difference from median of the pv of every palletize session in %

     //     //? 4.5) Filter out those <= median

     //     //? 5) Get the teams that have the highest +% found (10 best above median)
     //     return $leaderBoard;
     // }
     //  (CONVERT(datetime, '18-06-12 10:34:09 PM', 5));


     /**
      * Undocumented function
      *
      * @param [type] $startDate
      * @param [type] $endDate
      * @param [type] $variant_id
      * @return array
      */
  public function getTeamLeaderboard($startDate, $endDate, $variant_id): array
    {

        $leaderBoard = [];

        // $teamsAvgProductivity = $this->getTeamsAvgProgress($startDate, $endDate);
        $sessions = $this->getSessionsForVariant($startDate, $endDate, $variant_id);
         if (empty($sessions)) {
            return $leaderBoard; // EMPTY ARRAY
         }


         // $sql = "SELECT ps.session_id, t.variant_id, TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time) as duration, ps. units
         // FROM palletize_session ps
         // JOIN pallet p ON ps.pallet_id = p.pallet_id
         // JOIN tote t ON t.tote_id = p.tote_id
         // WHERE t.variant_id = :variant
         // AND ps.start_time BETWEEN :start AND :end
         // ORDER BY ps.start_time ASC";

         // // $sessions = $this->selectAll($sql, ["variant" => $variant_id, "start" => $startDate, "end" => $endDate]);
         // if(empty($sessions))
         // {
         //     return [];
         // }

         $rates = [];
         foreach ($sessions as $key => $session) {
             $rates[] = $session['rate'];
         }

         if (empty($rates)) {
             return []; // EMPTY ARRAY
         }

         //? get median:
         $median = $this->calculateMedian($rates);

         //? above median sessions:
         $aboveMedian = [];

         foreach ($sessions as $key => $session) {
             if ($session['rate'] > $median) //don't care if they are worse or same as median
             {
                 $overPercentage = (($session['rate'] - $median) / $median) * 100;

                 $aboveMedian[] = [
                     "team_id" => $session['team_id'],
                     "session_id" => $session['session_id'],
                     "variant_id" => $variant_id,
                     "rate" => $session['rate'],
                     "percent_above_median" => $overPercentage
                 ];
             }
         }

         //Reference for sorting array: https://www.php.net/manual/en/function.usort.php
         //?_sorting best 5:
         // usort($aboveMedian, "$this->sorter($a, $b)");
         usort($aboveMedian, [$this,'aboveMedianSorter']);

        $leaderBoard = array_slice($aboveMedian, 0, 5);

        return $leaderBoard;
    }

    /**
     * Undocumented function
     *
     * @param [type] $a
     * @param [type] $b
     * @return void
     */
    function aboveMedianSorter($a, $b)
    {
        return $a['percent_above_median'] <=> $b['percent_above_median'];
    }

    /**
     * Undocumented function
     *
     * @param [type] $startDate
     * @param [type] $endDate
     * @param [type] $variant_id
     * @return array
     */
    // public function getTeamsBestSessionsForVariant($startDate, $endDate, $variant_id): array
    public function getSessionsForVariant($startDate, $endDate, $variant_id): array
    {
        $best = [];

        $sql = "SELECT ps.session_id, ps.units, ps.start_time,ps.end_time, TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time) as duration, p.station_id, te.team_id
        FROM palletize_session ps
        JOIN pallet p ON ps.pallet_id = p.pallet_id
        JOIN tote t ON t.tote_id = p.tote_id
        JOIN team te ON te.station_id = p.station_id
        WHERE t.variant_id = :variant
        AND ps.start_time BETWEEN :start AND :end";

        // $sql = "SELECT ps.session_id, t.variant_id, TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time) as duration, ps.units
        // FROM palletize_session ps
        // JOIN pallet p ON ps.pallet_id = p.pallet_id
        // JOIN tote t ON t.tote_id = p.tote_id
        // WHERE t.variant_id = :variant
        // AND ps.start_time BETWEEN :start AND :end
        // ORDER BY ASC";

        $sessions = $this->selectAll($sql, ["variant" => $variant_id, "start" => $startDate, "end" => $endDate]);

        if (empty($sessions)) {
            return [];
        }

        foreach ($sessions as $key => $session) {
            if ($session['duration'] <= 0 || $session['units'] <= 0) {
                continue; //sSKIP empty ones if there was a problem, don't awnt extrreme values to mess up accuracy
            }

            $rate = $session['units'] / $session['duration'];

            $best[] = [
                "session_id" => $session['session_id'],
                "team_id" => $session['team_id'],
                "rate" => $rate
            ];
        }

        return $best;
    }

    /**
     * Undocumented function
     *
     * @param [type] $startDate
     * @param [type] $endDate
     * @param [type] $variant_id
     * @return void
     */
    public function getBestSessionForVariant($startDate, $endDate, $variant_id)
    {
        // $sql = "SELECT ps.session_id, t.variant_id, TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time) as duration, ps.units
        // FROM palletize_session ps JOIN pallet p ON ps.pallet_id = p.pallet_id
        // JOIN tote t ON t.tote_id = p.tote_id
        // WHERE t.variant_id = :variant AND ps.start_time BETWEEN :start AND :end
        //LIMIT 10";
        //$stmt = $this->execute(;)
        $sessions = $this->getSessionsForVariant($startDate, $endDate, $variant_id);

        if(empty($session))
        {
            return null;
        }

        $best = null;

        foreach ($sessions as $key => $session)
        {
            if($best == null || $session['rate'] > $best['rate'])
            {
                $best = $session;
            }
        }

        return $best;
    }


    /**
     * Undocumented function
     *
     * @param [type] $startDate
     * @param [type] $endDate
     * @param [type] $variant_id
     * @return void
     */
    public function getAvgRateForVariant($startDate, $endDate, $variant_id)
    {
        $sessions = $this->getSessionsForVariant($startDate, $endDate, $variant_id);

        if(empty($session))
        {
            return 0;
        }

        $sum = 0;
        $count = count($sessions);

        if($count <= 0)
        {
            return 0;
        }

        foreach ($sessions as $key => $session)
        {
            $sum += $session['rate'];
        }


        return $sum / $count;
    }


    /**
     * Undocumented function
     *
     * @param [type] $startDate
     * @param [type] $endDate
     * @param [type] $variant_id
     * @return void
     */
    public function getBestTeamForVariant($startDate, $endDate, $variant_id)
    {
        $sessions = $this->getSessionsForVariant($startDate, $endDate, $variant_id);

        if(empty($session))
        {
            return null;
        }

        $teams = [];

        foreach ($sessions as $key => $session)
        {
            $team = $session['team_id'];

            if(isset($teams[$team])) //Make sure the team has sessions
            {
                $teams[$team] = [
                    'team_id' => $team,
                    'total_rate' => 0,
                    'count' => 0,
                ];
            }

            $teams[$team]['total_rate'] += $session['rate'];

            $teams[$team]['count']++; //store counter for the number of sessions of this variant for that team
        }

        $bestTeamId = null;

        $bestAvg = 0; //best avg rates per minute

        foreach ($teams as $key => $team) {

            if($team['count'] <= 0)
            {
                continue; //skip useless teams
            }


            $avg = $team['total_rate'] / $team['count'];

            if($avg > $bestAvg)
            {
                $bestAvg = $avg;

                $bestTeamId = $team['team_id'];
            }
        }

        if($bestTeamId == null)
        {
            return null;
        }

        $result = [
            'team_id' => $bestTeamId,
            'avg_rate' => $bestAvg
        ];

        return $result;
    }


    /**
     * Undocumented function
     *
     * @param [type] $startDate
     * @param [type] $endDate
     * @param [type] $variant_id
     * @return void
     */
    public function getTeamsVariantLeaderboard($startDate, $endDate, $variant_id)
    {
        $sessions = $this->getSessionsForVariant($startDate, $endDate, $variant_id);

        if(empty($session))
        {
            return null;
        }

        $teams = [];

        foreach ($sessions as $key => $session)
        {
            $team = $session['team_id'];

            if(isset($teams[$team])) //Make sure the team has sessions
            {
                $teams[$team] = [
                    'team_id' => $team,
                    'total_rate' => 0,
                    'count' => 0,
                ];
            }

            $teams[$team]['total_rate'] += $session['rate'];
            $teams[$team]['count']++;
        }

        $avgRates = [];

        foreach ($teams as $key => $team)
        {
            if($team['count'] <= 0)
            {
                continue; //SKip useless ones
            }

            $avgRates[] = [
                'team_id' => $team['team_id'],
                'average_rate' => $team['total_rate'] / $team['count']
            ];
        }

        usort($avgRates, [$this, 'avgRatesSorter']);

        return $avgRates;
    }

    /**
     * Helper method for getTeamsVariantLeaderboard method
     * Sorts an array by descending average_rate values
     * @param [type] $a first value to compare
     * @param [type] $b second value to compare
     * @return void updates th array to be sorted, no return statement
     */
    function avgRatesSorter($a, $b)
    {
        return $a['average_rate'] <=> $b['average_rate'];
    }

    /**
     * Undocumented function
     *
     * @param integer $session_id
     * @return void
     */
    public function getSessionDurationMins(int $session_id)
    {
        $sql = "SELECT TIMESTAMPDIFF(MINUTE, start_time, end_time) FROM palletize_session WHERE session_id = :id";

        return $this->selectOne($sql, ["id" => $session_id]) ?? 0;
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

        $sessions = $this->selectAll($sql, ["team" => $team_id, "start" => $startDate, "end" => $endDate]);

        foreach ($sessions as $key => $session) {
            $units = $session['units'];
            $duration = $session['duration'];

            if ($units > 0 && $duration > 0) {
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

        foreach ($teams as  $team) {

            $team_id = $team['team_id'];

            $oneProgress = $this->getTeamProgress($team_id, $startDate, $endDate);
            $progressSize = count($oneProgress);

            if ($progressSize > 0) {
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


    /**
     * Undocumented function
     *
     * @param [type] $stationId
     * @param [type] $startDate
     * @param [type] $endDate
     * @return array
     */
    public function getStationPerformance($stationId, $startDate, $endDate): array
    {
        $progress = []; //Chronological

        $sql = "SELECT TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time) as duration, ps.units
        FROM palletize_session ps
        JOIN pallet p ON p.pallet_id = ps.pallet_id
        WHERE ps.start_time BETWEEN :start AND :end
        AND p.station_id = :stationId
        ORDER BY ps.start_time ASC";

        $sessions = $this->selectAll($sql, ["stationId" => $stationId, "start" => $startDate, "end" => $endDate]);

        foreach ($sessions as $key => $session) {
            $units = $session['units'];
            $duration = $session['duration'];

            if ($units > 0 && $duration > 0) {
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
        if ($date == null) {
            return [];
        }

        $start = $date . ' 00:00:00';
        $end = $date . ' 23:59:59';

        return $this->getTeamProgress($teamId, $start, $end);
    }

    /**
     * Undocumented function
     *
     * @param array $avgRates
     * @return float
     */
    public function calculateMedian(array $avgRates): float
    {
        if (empty($avgRates)) {
            return 0; //problem
        }

        sort($avgRates);

        $arrLength = count($avgRates);

        $halfLength = $arrLength / 2;

        $medianIndex = (int) $halfLength;

        if ($arrLength % 2 == 1) {
            $median = $avgRates[$medianIndex];
        } else {
            $second_half_length = $halfLength;

            $first_half_length = $second_half_length - 1;

            $first_half = $avgRates[$first_half_length];

            $second_half = $avgRates[$second_half_length];

            $median = ($first_half + $second_half) / 2;
        }


        return $median;
    }

    //Reference: https://www.educative.io/answers/how-to-get-the-median-of-an-array-of-numbers-in-php

    /**
     * Undocumented function
     *
     * @param [type] $int
     * @param string $date
     * @return array
     */
    public function getProductSummary(int $variant_id, string $date): array
    {
        $startTime = $date. ' 00:00:00';
        $endTime = $date. ' 00:00:00';

        $sql = "SELECT
                COALESCE(SUM(ps.units),0) AS total_units,
                COALESCE(SUM(TIMESTAMPDIFF(MINUTE, ps.start_time, ps.end_time)),0) AS total_minutes
                FROM palletize_session ps
                JOIN pallet p ON ps.pallet_id = p.pallet_id
                JOIN tote t ON t.tote_id = p.tote_id
                WHERE t.variant_id = :variant
                AND ps.start_time BETWEEN :start AND :end
                AND ps.end_time IS NOT NULL";

        //Reference: got help for writing lines 508-515*

        $row = $this->selectOne($sql, ["variant" => $variant_id, "start" => $startTime, "end" => $endTime]);

        $totalUnits = (int)($row['total_units'] ?? 0);
        $totalMinutes = (int)($row['total_minutes'] ?? 0);
        $avgRatePerMin = $totalMinutes ? ($totalUnits / $totalMinutes) : 0;

        return [
            'variant_id' => $variant_id,
            'date' => $date,
            'total_units' => $totalUnits,
            'avg_rate_per_min' => $avgRatePerMin
        ];
    }

    /**
     * Undocumented function
     *
     * @param integer $station_id
     * @param string $start_time
     * @return array
     */
    public function getTeamForSessionDay(int $station_id, string $start_time): array
    {

        $sql = "SELECT team_id FROM team WHERE station_id = :station AND DATE(team_date) = DATE(:start) LIMIT 1"; //Remove limit after testing maybe

        $team = $this->selectOne($sql, ["station" => $station_id, "start" => $start_time]);

        return $team['team_id'] ?? null;
    }

    /**
     * Undocumented function
     *
     * @param integer $station_id
     * @param string $start_time
     * @return array
     */
    public function getSessions(int $station_id, string $start_time): array
    {
        return [];
    }

}
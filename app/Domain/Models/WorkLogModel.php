<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

/**
 * class WorkLogModel
 *
 * This class contains all operations for the work log page for pallet and palletize table in our database.
 * This includes the inserting, updating, searching,
 */

class WorkLogModel extends BaseModel
{

    public function __construct(PDOService $pDOService) {
        parent::__construct($pDOService);
    }

    //returns the user's station's work done for today for index view
    public function getCurrentWorkLogs($user_id): ?array {
        $stmt = "SELECT ps.session_id, v.variant_description, t.batch_number, ps.start_time, ps.end_time, ps.units, ps.break_start, ps.break_time,
            ps.mess, ps.notes, p.pallet_id, s.station_name FROM palletize_session ps JOIN pallet p ON ps.pallet_id = p.pallet_id
                JOIN tote t ON p.tote_id = t.tote_id
                JOIN product_variant v ON t.variant_id = v.variant_id
                LEFT JOIN station s ON p.station_id = s.station_id
                WHERE DATE(ps.start_time) = CURDATE() AND p.station_id IN (
                    SELECT t.station_id
                    FROM team t
                    JOIN team_members tm ON tm.team_id = t.team_id
                    WHERE tm.user_id = :user_id AND DATE(t.team_date) = CURDATE())
                ORDER BY ps.start_time ASC, p.pallet_id";
        $params = [':user_id' => $user_id];
        return $this->selectAll($stmt, $params);
    }

    //returns the work done for a specified station (for admin)
    public function getSelectedWorkLogs($station_id): ?array {
        $stmt = "SELECT v.variant_description, t.batch_number, ps.start_time, ps.end_time, ps.units,
                ps.break_start, ps.break_time, ps.mess, ps.notes, p.pallet_id, s.station_name, team.team_id, team.team_date
                FROM palletize_session ps
                    JOIN pallet p ON ps.pallet_id = p.pallet_id
                    JOIN tote t ON p.tote_id = t.tote_id
                    JOIN product_variant v ON t.variant_id = v.variant_id
                    LEFT JOIN station s ON p.station_id = s.station_id
                    LEFT JOIN team ON team.station_id = p.station_id
                    WHERE DATE(ps.start_time) = CURDATE()
                        AND p.station_id = :station_id
                        ORDER BY ps.start_time DESC, p.pallet_id";
        $params = [':station_id' => $station_id];
        return $this->selectAll($stmt, $params);
    }

    public function initialInsertPallet(array $data): ?array {
        $batch = $data['batch_number'] ?? null;
        $stationId = $data['station_id'] ?? null;
        $variantId = $data['variant_id'] ?? null;

        if (empty($batch) || empty($stationId)) {
            return null;
        }

        // if there is already a tote with specified batch number
        $toteRow = $this->selectOne("SELECT tote_id FROM tote WHERE batch_number = ?", [$batch]);

        if ($toteRow && isset($toteRow['tote_id'])) {
            $toteId = $toteRow['tote_id'];
        } else {
            // else create the tote with specified batch number
            $insertToteStmt = "INSERT INTO tote (variant_id, batch_number) VALUES (:variant_id, :batch)";
            $params = [
                ':variant_id' => $variantId,
                ':batch' => $batch
            ];
            $this->execute($insertToteStmt, $params);

            // query to get created tote id
            $toteRow = $this->selectOne("SELECT tote_id FROM tote WHERE batch_number = ? ORDER BY tote_id DESC LIMIT 1", [$batch]);
            if (!$toteRow || !isset($toteRow['tote_id'])) {
                return null;
            }
            $toteId = (int)$toteRow['tote_id'];
        }

        //create pallet with tote_id and station_id
        $insertPalletStmt = "INSERT INTO pallet (tote_id, station_id) VALUES (:tote_id, :station_id)";
        $this->execute($insertPalletStmt, [':tote_id' => $toteId, ':station_id' => $stationId]);

        //get that pallet id
        $palletRow = $this->selectOne(
            "SELECT pallet_id FROM pallet WHERE tote_id = ? AND station_id = ? ORDER BY pallet_id DESC LIMIT 1",
            [$toteId, $stationId]
        );
        if (!$palletRow || !isset($palletRow['pallet_id'])) {
            return null;
        }
        $palletId = (int)$palletRow['pallet_id'];

        //create palletize session with pallet id and start time
        $insertSessionStmt = "INSERT INTO palletize_session (pallet_id, start_time) VALUES (:pallet_id, NOW())";
        $this->execute($insertSessionStmt, [':pallet_id' => $palletId]);

        // get newest created palletize session
        $sessionRow = $this->selectOne(
            "SELECT session_id FROM palletize_session WHERE pallet_id = ? ORDER BY session_id DESC LIMIT 1",
            [$palletId]
        );
        $sessionId = $sessionRow['session_id'] ?? null;

        return [
            'tote_id'    => $toteId,
            'pallet_id'  => $palletId,
            'session_id' => $sessionId !== null ? (int)$sessionId : null
        ];
    }

    //check if there is incomplete palletize session for specified user's station today
    //return true if there is an incomplete session/active pallet
    public function checkPalletizeComplete($user_id): bool {
        $stmt = "
            SELECT 1
            FROM palletize_session ps
            JOIN pallet p ON ps.pallet_id = p.pallet_id
            WHERE ps.end_time IS NULL
              AND DATE(ps.start_time) = CURDATE()
              AND p.station_id IN (
                  SELECT t.station_id
                  FROM team t
                  JOIN team_members tm ON t.team_id = tm.team_id
                  WHERE tm.user_id = :user_id
                    AND DATE(t.team_date) = CURDATE()
              )
            LIMIT 1
        ";
        $params = [':user_id' => $user_id];
        $row = $this->selectOne($stmt, $params);

        // If a row exists there is an incomplete session at the user's station
        return !empty($row);
    }

    public function completePalletizeSession(array $data) {
        $stmt = "UPDATE palletize_session
                 SET end_time = NOW(),
                     units = :units,
                     mess = :mess,
                     notes = :notes
                 WHERE session_id = :session_id";

        $params = [
            ':units'      => $data['units'],
            ':mess'       => $data['mess'],
            ':notes'      => $data['notes'],
            ':session_id' => $data['session_id']
        ];

        return $this->execute($stmt, $params);
    }

    public function startBreak(array $data) {
        //only set break_start if not already set
        $stmt = "UPDATE palletize_session
                 SET break_start = NOW()
                 WHERE session_id = :session_id
                   AND break_start IS NULL";

        $params = [
            ':session_id'  => $data['session_id']
        ];

        $this->execute($stmt, $params);
    }

    public function endBreak(array $data) {
        $sessionId = $data['session_id'] ?? null;
        if (empty($sessionId)) {
            return;
        }

        //make sure break_start has a value
        $row = $this->selectOne("SELECT break_start, break_time FROM palletize_session WHERE session_id = ?",[$sessionId]);

        if (!$row || empty($row['break_start'])) {
            //break_start has no value
            return;
        }

        //add time to break_time and set break_start to null
        $stmt = "UPDATE palletize_session
            SET break_time = COALESCE(break_time, 0) + TIMESTAMPDIFF(MINUTE, break_start, NOW()),
                break_start = NULL
            WHERE session_id = :session_id";

        $params = [':session_id' => $sessionId];
        $this->execute($stmt, $params);
    }

    public function isOnBreak($session_id) {
        $stmt = "SELECT 1 FROM palletize_session WHERE session_id = :session_id AND break_start IS NOT NULL LIMIT 1";
        $row = $this->selectOne($stmt, [':session_id' => $session_id]);
        return !empty($row);
    }
}


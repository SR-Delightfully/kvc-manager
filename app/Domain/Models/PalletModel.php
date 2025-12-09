<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use DateTime;
use Exception;

class PalletModel extends BaseModel
{
    public function __construct(PDOService $pDOService)
    {
        parent::__construct($pDOService);
    }

    public function getPalletCompleteById($id)
    {
        $stmt = "SELECT pallet.*, palletize_session.* FROM pallet LEFT JOIN palletize_session ON pallet.pallet_id =  palletize_session.pallet_id WHERE pallet.pallet_id = :id";
        $params = [':id' => $id];
        $pallet = $this->selectOne($stmt, $params);
        return $pallet;
    }

    public function getAllPalletsComplete(): ?array
    {
        $stmt = "SELECT pallet.*, palletize_session.* FROM pallet LEFT JOIN palletize_session ON pallet.pallet_id =  palletize_session.pallet_id";
        $pallets = $this->selectAll($stmt);
        return $pallets;
    }

    public function getAllPalletsClean() {
        $stmt = "SELECT p.pallet_id, v.variant_description AS variant_description, t.batch_number AS tote_id, s.station_name AS station_id, l.start_time, l.end_time, l.units, l.break_time, l.mess, l.notes FROM pallet p LEFT JOIN tote t ON p.tote_id = t.tote_id LEFT JOIN product_variant v ON v.variant_id = t.variant_id LEFT JOIN station s ON s.station_id = p.station_id LEFT JOIN palletize_session l ON l.pallet_id = p.pallet_id";
        $pallets = $this->selectAll($stmt);
        return $pallets;
    }

    public function getAllPalletsSimple(): ?array
    {
        $stmt = "SELECT * FROM pallet";
        $pallets = $this->selectAll($stmt);
        return $pallets;
    }

    public function getAll(): array
    {
        return $this->getAllPalletsComplete() ?? [];
    }

    public function getByUser(int $userId): array
    {
        $stmt = "SELECT pallet.*, palletize_session.*
                FROM pallet
                LEFT JOIN palletize_session ON pallet.pallet_id = palletize_session.pallet_id
                WHERE pallet.user_id = :user_id";
        return $this->selectAll($stmt, [':user_id' => $userId]) ?? [];
    }

    public function find(int $id): ?array
    {
        return $this->getPalletCompleteById($id) ?? null;
    }

    public function create(array $data): void
    {
        $stmt = "INSERT INTO pallet (user_id, name, created_at) VALUES (:user_id, :name, NOW())";
        $params = [
            ':user_id' => $data['user_id'],
            ':name' => $data['name'] ?? '',
        ];
        $this->execute($stmt, $params);
    }

    public function update(int $id, array $data): void
    {
        $stmt = "UPDATE pallet SET name = :name WHERE pallet_id = :id";
        $params = [
            ':id' => $id,
            ':name' => $data['name'] ?? '',
        ];
        $this->execute($stmt, $params);
    }

    public function updatePalletize(int $id, array $data): void
    {
        $stmt = "UPDATE palletize_session SET start_time = :start_time,
                                end_time = :end_time,
                                units = :units,
                                break_time = :break_time,
                                mess = :mess,
                                notes = :notes WHERE pallet_id = :id";
        $params = [
            ':id' => $id,
            ':start_time' => $data['start_time'],
            ':end_time' =>$data['end_time'],
            ':units' => $data['units'],
            ':break_time' => $data['break_time'],
            ':mess' => $data['mess'],
            ':notes' => $data['notes']
        ];
        $this->execute($stmt, $params);
    }

    public function delete(int $id): void
    {
        $stmt = "DELETE FROM pallet WHERE pallet_id = :id";
        $this->execute($stmt, [':id' => $id]);
    }

    public function getAllTotes(): ?array
    {
        $stmt = "SELECT * FROM tote";
        $tote = $this->selectAll($stmt);
        return $tote;
    }
}



    // /*
    // session_id INT PRIMARY KEY AUTO_INCREMENT,
    // pallet_id INT NOT NULL,
    // start_time DATETIME NOT NULL,
    // end_time DATETIME NULL,
    // units INT NULL,
    // break_start DATETIME NULL,
    // break_time INT NULL,
    // mess BOOLEAN NULL,
    // notes VARCHAR(100) NULL,
    // FOREIGN KEY (pallet_id) REFERENCES pallet(pallet_id)
    // */
    // // public function insertFullPalletizeSession(int $pallet_id, String $start_time, String $end_time, int $units, String $break_start, int $break_time, bool $mess, String $notes): int
    // // {
    // //     //? 1) Sanitize Data and convert Php->Sql format
    // //     // $start_time = new DateTime($start_time);
    // //     $dt = DateTime::createFromFormat("d.m.Y H:i:s", $start_time);
    // //     if ($dt === false) {
    // //         //TODO fix the way to output the error to the user
    // //         throw new Exception("Invalid date");
    // //     }
    // //     $sqlStartTime = $dt->format("Y-m-d H:i:s");

    // //     $dt = DateTime::createFromFormat("d.m.Y H:i:s", $end_time);
    // //     if ($dt === false) {
    // //         //TODO fix the way to output the error to the user
    // //         throw new Exception("Invalid date");
    // //     }
    // //     $sqlEndTime = $dt->format("Y-m-d H:i:s");

    // //     //? 2) Insert
    // //     $sql = "INSERT INTO palletize_session(pallet_id, start_time, end_time, units, breaks, break_time, mess, notes) VALUE(
    // //     :pallet_id,
    // //     :start_time,
    // //     :end_time, units,
    // //     :breaks,
    // //     :break_time,
    // //     :mess,
    // //     :notes)";

    // //     //? 3) Execute
    // //     $this->execute($sql, [
    // //         "pallet_id" => $pallet_id,
    // //         "start_time" => $sqlStartTime,
    // //         "end_time" => $sqlEndTime,
    // //         "units" => $units,
    // //         // "breaks" => $breaks,
    // //         "break_time" => $break_time,
    // //         "mess" => $mess,
    // //         "notes" => $notes
    // //     ]);

    // //     //? 4) return row id
    // //     return (int)$this->lastInsertId();
    // // }

    //     /*
    // session_id INT PRIMARY KEY AUTO_INCREMENT,
    // pallet_id INT NOT NULL,
    // //! I want to add batch_num the table
    // start_time DATETIME NOT NULL,
    // end_time DATETIME NULL,
    // units INT NULL,
    // break_start DATETIME NULL,
    // break_time INT NULL,
    // mess BOOLEAN NULL,
    // notes VARCHAR(100) NULL,
    // FOREIGN KEY (pallet_id) REFERENCES pallet(pallet_id)
    // */

    // /**
    //  *
    //  * @param integer $pallet_id
    // //  param String $start_time
    //  * @param integer $units, by default it's 0
    //  * @param bool $mess, default is false
    //  * @param string $notes
    //  * @throws Exception if the insertion failed
    //  * @return int the id of the newly inserted row, if something went wrong, it's -1
    //  */

    // public function insertPalletizeSessionStart(int $pallet_id, $batch_num): int
    // {
    //     try {
    //         //? 1) Sanitize Data and convert Php->Sql format
    //         // $start_time = new DateTime($start_time);
    //         // $dt = DateTime::createFromFormat("d.m.Y H:i:s", $start_time);
    //         // if ($dt === false) {
    //         //     //TODO fix the way to output the error to the user
    //         //     throw new Exception("Invalid date");
    //         // }
    //         // $sqlStartTime = $dt->format("Y-m-d H:i:s");

    //         // if (strlen($notes) > 100) {
    //         //     throw new Exception("Notes are too long.");
    //         // }

    //         //? 2) Insert
    //         $sql = "INSERT INTO palletize_session(pallet_id, start_time) VALUE(
    //         :pallet_id,
    //         GETDATE())";

    //         //? 3) Execute
    //         $this->execute($sql, [
    //             "pallet_id" => $pallet_id,
    //             // "start_time" => $sqlStartTime,
    //             // "units" => $units,
    //             // "break_start" => $break_start,
    //             // "break_time" => $break_time,
    //             // "mess" => $mess,
    //             // "notes" => $notes
    //         ]);
    //     } catch (Exception $e) {
    //         print($e->getMessage());
    //         return -1;
    //     }

    //     //? 4) return row id
    //     return (int)$this->lastInsertId() ?? -1;
    // }

    // public function insertPalletizeSessionEnd(int $session_id, String $notes = "", int $units)
    // {
    //     //? Input Validation:
    //     if ($session_id == null || $session_id <= 0) {
    //         print("Invalid session id.");
    //         return;
    //     }

    //     if ($units == null || $units <= 0) {
    //         print("Units count needed to complete session!");
    //         return;
    //     }

    //     if(strlen($notes) > 100) {
    //         print("Notes are too long.");
    //         return;
    //     }

    //     try {
    //         $sql = "UPDATE palletize_session
    //             SET end_time = CURRENT_TIMESTAMP,
    //             units = :units, notes = :notes";
    //         $update = $this->execute($sql, ['units' => $units, 'notes' => $notes]);
    //     } catch (Exception $e) {
    //         print("Could not complete palletize session: " . $e->getMessage());
    //     }
    // }
    // /**
    //  * Records the start of a break in a palletize_session
    //  * @param int $session_id the ID of the session to edit
    //  * @return void updates the record of the palletize_session with break_start
    //  */
    // public function breakStart(int $session_id)
    // {
    //     $sql = "SELECT * FROM palletize_session WHERE session_id = :id";
    //     $palletize_session = $this->selectOne($sql, ["id" => $session_id]);

    //     if ($palletize_session == null) {
    //         return "Session not found.";
    //     }

    //     $sql2 = "UPDATE palletize_session SET break_start = GETDATE()
    //     WHERE session_id = :id";

    //     $update = $this->execute($sql, ["id" => $session_id]);

    //     if (!$update)
    //         return "Failed to update palletize session break start.";
    // }

    // /**
    //  * Records the end of a break in a palletize_session
    //  * and calculates the total break time, then resets the break_start
    //  * @param int $session_id the ID of the session to edit
    //  * @return void updates the record of the palletize_session
    //  */
    // public function breakStop(int $session_id)
    // {
    //     try {
    //         //? 1) verify session_id in db
    //         $sql = "SELECT * FROM palletize_session WHERE session_id = :id";
    //         $palletize_session = $this->selectOne($sql, ["id" => $session_id]);

    //         if ($palletize_session == null) {
    //             return "Session not found";
    //         }

    //         //? 2) retrieve the start_time and break_time
    //         $breakStart = $palletize_session["break_start"];
    //         $breakTime = $palletize_session["break_time"] ?? 0;

    //         // $sql2 = "SELECT DATEDIFF(MINUTE, :start, GETDATE())";
    //         $sql2 = "SELECT TIMESTAMPDIFF(MINUTE, :start, GETDATE())";
    //         $breakTime += $this->selectOne($sql2, ["start" => $breakStart]);

    //         //? 3) update row to reset the break start to nothing and add to the break time
    //         $sql3 = "UPDATE palletize_session
    //             SET break_start = NULL, break_time = :time
    //             WHERE session_id = :id";

    //         $this->execute($sql3, ["time" => $breakTime, "id" => $session_id]);
    //     } catch (Exception $e) {
    //         return "Cannot Stop the break: {$e->getMessage()}.";
    //     }
    // }

    // // /**
    // //  * Edits the palletize_session record to declare a mess
    // //  *
    // //  * @param [type] $session_id
    // //  * @return void
    // //  */
    // // public function signalSessionMess($session_id) {

    // // }
// }

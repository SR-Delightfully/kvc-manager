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

    public function getAllPalletsSimple(): ?array
    {
        $stmt = "SELECT * FROM pallet";
        $pallets = $this->selectAll($stmt);
        return $pallets;
    }

    /*
    session_id INT PRIMARY KEY AUTO_INCREMENT,
    pallet_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NULL,
    units INT NULL,
    break_start DATETIME NULL,
    break_time INT NULL,
    mess BOOLEAN NULL,
    notes VARCHAR(100) NULL,
    FOREIGN KEY (pallet_id) REFERENCES pallet(pallet_id)
    */
    public function insertFullPalletizeSession(int $pallet_id, String $start_time, String $end_time, int $units, String $break_start, int $break_time, bool $mess, String $notes): int
    {
        //? 1) Sanitize Data and convert Php->Sql format
        // $start_time = new DateTime($start_time);
        $dt = DateTime::createFromFormat("d.m.Y H:i:s", $start_time);
        if ($dt === false) {
            //TODO fix the way to output the error to the user
            throw new Exception("Invalid date");
        }
        $sqlStartTime = $dt->format("Y-m-d H:i:s");

        $dt = DateTime::createFromFormat("d.m.Y H:i:s", $end_time);
        if ($dt === false) {
            //TODO fix the way to output the error to the user
            throw new Exception("Invalid date");
        }
        $sqlEndTime = $dt->format("Y-m-d H:i:s");

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
            "start_time" => $sqlStartTime,
            "end_time" => $sqlEndTime,
            "units" => $units,
            // "breaks" => $breaks,
            "break_time" => $break_time,
            "mess" => $mess,
            "notes" => $notes
        ]);

        //? 4) return row id
        return (int)$this->lastInsertId();
    }

        /*
    session_id INT PRIMARY KEY AUTO_INCREMENT,
    pallet_id INT NOT NULL,
    //! I want to add batch_num the table
    start_time DATETIME NOT NULL,
    end_time DATETIME NULL,
    units INT NULL,
    break_start DATETIME NULL,
    break_time INT NULL,
    mess BOOLEAN NULL,
    notes VARCHAR(100) NULL,
    FOREIGN KEY (pallet_id) REFERENCES pallet(pallet_id)
    */

    /**
     *
     * @param integer $pallet_id
     * @param String $start_time
     * @param integer $units, by default it's 0
     * @param bool $mess, default is false
     * @param string $notes
     * @throws Exception if the insertion failed
     * @return int the id of the newly inserted row, if something went wrong, it's -1
     */
    public function insertPalletizeSession(int $pallet_id, $batch_num): int
    {
        try {
            //? 1) Sanitize Data and convert Php->Sql format
            // $start_time = new DateTime($start_time);
            // $dt = DateTime::createFromFormat("d.m.Y H:i:s", $start_time);
            // if ($dt === false) {
            //     //TODO fix the way to output the error to the user
            //     throw new Exception("Invalid date");
            // }
            // $sqlStartTime = $dt->format("Y-m-d H:i:s");

            // if (strlen($notes) > 100) {
            //     throw new Exception("Notes are too long.");
            // }

            //? 2) Insert
            $sql = "INSERT INTO palletize_session(pallet_id, start_time) VALUE(
            :pallet_id,
            GETDATE())
            ";

            //? 3) Execute
            $this->execute($sql, [
                "pallet_id" => $pallet_id,
                // "start_time" => $sqlStartTime,
                // "units" => $units,
                // "break_start" => $break_start,
                // "break_time" => $break_time,
                // "mess" => $mess,
                // "notes" => $notes
            ]);
        } catch (Exception $e) {
            print($e->getMessage());
            return -1;
        }

        //? 4) return row id
        return (int)$this->lastInsertId() ?? -1;
    }

    /**
     * Records the start of a break in a palletize_session
     * @param int $session_id the ID of the session to edit
     * @return void updates the record of the palletize_session with break_start
     */
    public function breakStart(int $session_id) {
        $sql = "SELECT * FROM palletize_session WHERE session_id = :id";
        $palletize_session = $this->selectOne($sql, ["id" => $session_id]);

        if($palletize_session == null) {
            return "Session not found";
        }

        $sql2 = "Update palletize_session SET break_start = GETDATE()
        WHERE session_id = :id";

        $update = $this->execute($sql, ["id" => $session_id]);

        if(!$update)
            return "Failed to update palletize session break start";
    }

    /**
     * Records the end of a break in a palletize_session
     * and calculates the total break time, then resets the break_start
     * @param int $session_id the ID of the session to edit
     * @return void updates the record of the palletize_session
     */
    public function breakStop(int $session_id)
    {
        //? 1) verify session_id in db

        //? 2) retrieve the start_time and break_time


    }

    // /**
    //  * Edits the palletize_session record to decalre a mess
    //  *
    //  * @param [type] $session_id
    //  * @return void
    //  */
    // public function signalSessionMess($session_id) {

    // }
}

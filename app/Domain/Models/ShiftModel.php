<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ShiftModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }
    public function getShiftById($id): ?array {
        $stmt = "SELECT * FROM shift WHERE shift_id = :id";
        $params = [':id'=>$id];
        $shift = $this->selectOne($stmt,$params);
        return $shift;
    }
    public function getAllShifts(): ?array {
        $stmt = "SELECT * FROM shift";
        $shifts = $this->selectAll($stmt);
        return $shifts;
    }

    public function createShift(array $data): void {
        $stmt = "INSERT INTO shift(user_id, start_time, end_time) VALUES
        (:user_id, :sTime, :eTime)";
        $params = [':user_id'=>$data['user_id'],':sTime'=>$data['start_time'],':eTime'=>$data['end_time']];
        $this->execute($stmt, $params);
    }

    public function deleteShift(int $id){
        $stmt = "DELETE FROM shift WHERE shift_id = :id";
        $params = ['id'=>$id];
        $this->execute($stmt,$params);
    }

    public function updateShift($id, $data) {
        $stmt = "UPDATE shift SET
                    schedule_id = :schedule_id,
                    start_time = :sTime,
                    end_time = :eTime
                    WHERE shift_id = :id";

        $params = [':schedule_id'=>$data['schedule_id'],':sTime'=>$data['start_time'],':eTime'=>$data['end_time'],':id'=>$id];
        $this->execute($stmt,$params);
    }
}

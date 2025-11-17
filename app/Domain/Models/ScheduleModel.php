<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ScheduleModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    public function getScheduleById($id): ?array {
        $stmt = "SELECT * FROM schedule WHERE schedule_id = :id";
        $params = [':id'=>$id];
        $schedule = $this->selectOne($stmt,$params);
        return $schedule;
    }
    public function getAllSchedules(): ?array {
        $stmt = "SELECT * FROM schedule";
        $schedules = $this->selectAll($stmt);
        return $schedules;
    }

    public function createSchedule(array $data): void {
        $stmt = "INSERT INTO schedule(user_id, start_time, end_time) VALUES
        (:user_id, :sTime, :eTime)";
        $params = [':user_id'=>$data['user_id'],':sTime'=>$data['start_time'],':eTime'=>$data['end_time']];
        $this->execute($stmt, $params);
    }

    public function deleteSchedule(int $id){
        $stmt = "DELETE FROM schedule WHERE schedule_id = :id";
        $params = ['id'=>$id];
        $this->execute($stmt,$params);
    }

    public function updateSchedule($id, $data) {
        $stmt = "UPDATE schedule SET
                    user_id = :user_id,
                    start_time = :sTime,
                    end_time = :eTime,
                    schedule_status = :status
                    WHERE schedule_id = :id";

        $params = [':user_id'=>$data['user_id'],':sTime'=>$data['start_time'],':eTime'=>$data['end_time'],
        ':status'=>$data['schedule_status'],':id'=>$id];
        $this->execute($stmt,$params);
    }
}

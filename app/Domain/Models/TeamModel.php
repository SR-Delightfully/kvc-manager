<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class TeamModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    public function getTeamById($id): ?array {
        $stmt = "SELECT * FROM team WHERE team_id = :id";
        $params = [':id'=>$id];
        $team = $this->selectOne($stmt,$params);
        return $team;
    }
    public function getAllTeams(): ?array {
        $stmt = "SELECT * FROM team";
        $teams = $this->selectAll($stmt);
        return $teams;
    }

    public function getAllTeamsClean() {
        $stmt = "SELECT t.team_id, s.station_name AS station_id, t.team_date FROM team t LEFT JOIN station s ON t.station_id = s.station_id";
        $teams = $this->selectAll($stmt);
        return $teams;
    }

    public function getTeamCleanById($id) {
        $stmt = "SELECT t.team_id, s.station_name AS station_id, t.team_date FROM team t LEFT JOIN station s ON t.station_id = s.station_id WHERE t.team_id = :id";
        $params = [':id' => $id];
        $teams = $this->selectOne($stmt, $params);
        return $teams;
    }

    public function createTeam(array $data): void {
        $stmt = "INSERT INTO team(station_id, team_date) VALUES
        (:station_id, :team_date)";
        $params = [':station_id'=>$data['station_id'],':pCode'=>$data['team_date']];
        $this->execute($stmt, $params);
    }

    public function deleteTeam($id){
        $stmt = "DELETE FROM team WHERE team_id = :id";
        $params = [':id'=>$id];
        $this->execute($stmt,$params);
    }

    public function updateTeam($id, $data) {
        $stmt = "UPDATE team SET
                    station_id = :sId
                    WHERE team_id = :id";

        $params = [':sId'=>$data['station_id'],':id'=>$id];
        $this->execute($stmt,$params);
    }

    //FOR_TEAM_MEMBERS
    public function getTodayTeamMembersForUser($user_id): ?array {
        $stmt = "SELECT tm.team_id, t.team_date, s.station_name, u.user_id, u.first_name, u.last_name FROM team_members tm
            JOIN team t ON tm.team_id = t.team_id
            LEFT JOIN station s ON t.station_id = s.station_id
            JOIN users u ON tm.user_id = u.user_id
            WHERE tm.team_id IN (
                SELECT tm2.team_id FROM team_members tm2
                JOIN team t2 ON tm2.team_id = t2.team_id
                WHERE tm2.user_id = :user_id AND DATE(t2.team_date) = CURDATE())
            AND DATE(t.team_date) = CURDATE()
            ORDER BY u.first_name, u.last_name";

        $params = [':user_id' => $user_id];
        return $this->selectAll($stmt, $params);
    }

    public function getTodayTeamMembersForStation($station_id): ?array {
        $stmt = "SELECT tm.team_id, t.team_date, s.station_name, u.user_id, u.first_name, u.last_name FROM team t
            JOIN team_members tm ON t.team_id = tm.team_id
            JOIN users u ON tm.user_id = u.user_id
            LEFT JOIN station s ON t.station_id = s.station_id
            WHERE t.station_id = :station_id
              AND DATE(t.team_date) = CURDATE()
            ORDER BY u.first_name, u.last_name";
        $params = [':station_id' => $station_id];
        return $this->selectAll($stmt, $params);
    }

    public function getTeamMemberByUser($id): ?array {
        $stmt = "SELECT * FROM team_members WHERE user_id = :id";
        $params = [':id'=>$id];
        $user = $this->selectOne($stmt,$params);
        return $user;
    }

    public function getTeamMemberByTeamUser($team_id, $user_id): ?array {
        $stmt = "SELECT * FROM team_members WHERE team_id = :id AND user_id = :uId";
        $params = [':id'=>$team_id, ':uId'=>$user_id];
        $user = $this->selectOne($stmt,$params);
        return $user;
    }

    public function getAllTeamMembers(): ?array
    {
        $stmt = "SELECT * FROM team_members";
        $teamMembers = $this->selectAll($stmt);
        return $teamMembers;
    }

    public function getAllTeamMembersClean() {
        $stmt = "SELECT tm.team_id, s.station_name AS station_name, tm.user_id, u.first_name AS first_name, u.last_name AS last_name FROM team_members tm LEFT JOIN team t ON tm.team_id = t.team_id LEFT JOIN station s ON t.station_id = s.station_id LEFT JOIN users u ON tm.user_id = u.user_id ORDER BY t.team_date DESC, t.team_id, u.first_name";
        $teams = $this->selectAll($stmt);
        return $teams;
    }


    public function createTeamMembers(array $data): void {
        $stmt = "INSERT INTO team_members(team_id, user_id) VALUES
        (:tId, :uId)";
        $params = [':tId'=>$data['team_id'],':uId'=>$data['user_id']];
        $this->execute($stmt, $params);
    }

    public function deleteTeamMember($user_id, $team_id)
    {
        $stmt = "DELETE FROM team_members WHERE user_id = :uId AND team_id = :tId";
        $params = [':uId'=>$user_id, ':tId'=>$team_id];
        $this->execute($stmt,$params);
    }


    public function updateTeamMember($user_id, $data) {
    {
        //check if there is existing team with specified id
        $stmt = "SELECT team_id FROM team WHERE station_id = :new_station AND team_date = :team_date";
        $params = [':new_station'=>$data['station_id'],':team_date'=>$data['team_date']];
        $teamCheck = $this->selectOne($stmt, $params);

        if ($teamCheck) {
            $newTeam = $teamCheck['team_id'];
        } else {
            $stmt = "INSERT INTO team (station_id, team_date) VALUES
            (:sId, :team_date)";
            $params = [':sId'=>$data['station_id'],':team_date'=>$data['station_id']];
            $this->execute($stmt, $params);

            $newTeam = $this->lastInsertId();
        }

        $stmt = "DELETE FROM team_members WHERE user_id = :user_id AND team_id IN (SELECT team_id FROM team WHERE team_date = :team_date)";

        $params = [':user_id'=>$user_id,':team_date'=>$data['team_date']];
        $this->execute($stmt, $params);

        $stmt = "INSERT INTO team_members (team_id, user_id) VALUES
                (:team_id, :user_id)";

        $params = [':team_id'=>$data['team_id'],':user_id'=>$user_id];
        $this->execute($stmt,$params);
    }
}

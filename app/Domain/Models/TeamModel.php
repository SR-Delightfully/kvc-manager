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
                    station_id = :sId,
                    team_date = :tDate,
                    WHERE team_id = :id";

        $params = [':sId'=>$data['station_id'],':tDate'=>$data['team_date'],':id'=>$data['team_id']];
        $this->execute($stmt,$params);
    }

    //FOR_TEAM_MEMBERS
    public function getTeamMemberByUser($id): ?array {
        $stmt = "SELECT * FROM team_members WHERE user_id = :id";
        $params = [':id'=>$id];
        $user = $this->selectOne($stmt,$params);
        return $user;
    }

        public function getTeamMemberByStation($id): ?array {
        $stmt = "SELECT * FROM team_members WHERE station_id = :id";
        $params = [':id'=>$id];
        $user = $this->selectOne($stmt,$params);
        return $user;
    }

    public function getAllTeamMembers(): ?array
    {
        $stmt = "SELECT * FROM team_members";
        $teamMembers = $this->selectAll($stmt);
        return $teamMembers;
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


    public function updateTeamMember($user_id, $data)
    {
        //check if there is existing team with specified id
        $stmt = "SELECT team_id FROM team WHERE station_id = :new_station AND team_date = :team_date";
        $params = [':new_station'=>$data['station_id'],':team_date'=>$data['team_date']];
        $teamCheck = $this->selectOne($stmt, $params);

        //if there is then store that team id in a variable
        if ($teamCheck) {
            $newTeam = $teamCheck['team_id'];
        } else {
            //else, create new row for that new team
            $stmt = "INSERT INTO team (station_id, team_date) VALUES
            (:sId, :team_date)";
            $params = [':sId'=>$data['station_id'],':team_date'=>$data['station_id']];
            $this->execute($stmt, $params);

            $newTeam = $this->lastInsertId();
        }

        //remove old station for that employee
        $stmt = "DELETE FROM team_members WHERE user_id = :user_id AND team_id IN (SELECT team_id FROM team WHERE team_date = :team_date)";

        $params = [':user_id'=>$user_id,':team_date'=>$data['team_date']];
        $this->execute($stmt, $params);

        //insert new team_member row for employee
        $stmt = "INSERT INTO team_members (team_id, user_id) VALUES
                (:team_id, :user_id)";

        $params = [':team_id'=>$data['team_id'],':user_id'=>$user_id];
        $this->execute($stmt,$params);
    }
}

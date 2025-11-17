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

    public function getAllTeamMembers(): ?array {
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

    public function deleteTeamMember($user_id, $team_id){
        $stmt = "DELETE FROM team_members WHERE user_id = :uId AND team_id = :tId";
        $params = [':uId'=>$user_id, ':tId'=>$team_id];
        $this->execute($stmt,$params);
    }


    //TODO: refine this method since it can't be possible with update statement
    public function updateTeamMember($user_id, $team_id) {
        $stmt = "UPDATE team_members SET
                    $user_id = :$team_id,
                    product_code = :code,
                    product_name = :name
                    WHERE product_id = :id";
    }
}

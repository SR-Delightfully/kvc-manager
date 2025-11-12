<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class UserModel extends BaseModel
{

    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    public function getAllEmployees(): ?array {
        $stmt = "SELECT user_id, user_role, first_name, last_name, email, phone, user_dc, user_status FROM users";
        $users = $this->selectAll($stmt);
        return $users;
    }

    //i change the name of the function bc i find that 'register' doesnt represent correctly the function
    public function createUser(array $data): void {
        $stmt = "INSERT INTO users(first_name, last_name, email, phone, password) VALUES
            (:fName,:lName,:email,:phone,:pass)";

        $params = [':fName'=>$data['first_name'], ':lName'=>$data['last_name'], ':email'=>$data['email'],
                    ':phone'=>$data['phone'], ':pass'=>$data['password']];
        $this->execute($stmt,$params);
    }

    //TODO: Should login return boolean to indicate if successful login or array of information of logged in user to store in session array
    public function login(string $email, string $password): ?array {
        $stmt = "SELECT * FROM users WHERE email = :email AND password = :pass";
        $params = [':email'=>$email, ':pass'=>$password];
        $user = $this->selectOne($stmt,$params);
        return $user;
    }

    public function updateInformation(int $user_id,string $data): void {
        $stmt = "UPDATE users SET
            first_name = :first_name,
            last_name = :last_name,
            email = :email,
            phone = :phone,
            password = :password
            WHERE user_id = :user_id";

        $params = [':first_name'=>$data['first_name'],':last_name'=>$data['last_name'],':email'=>$data['email'],':phone'=>$data['phone'],
                    ':password'=>$data['password'], 'user_id'=>$data['user_id']];
        $this->execute($stmt,$params);
    }

    //returns list of first names of nearest team_date team members of given user_id
    public function getTeamMembersByStation(int $userId): ?array {
        $date = $this->getNearestTeamCreated($userId);

        if (!$date) {
            return null;
        }

        $stmt = "SELECT first_name FROM users WHERE user_id IN
            (SELECT user_id FROM team_members WHERE team_id IN
                (SELECT team_id FROM team WHERE team_date = :nextDate AND team_id IN
                    (SELECT team_id FROM team_members WHERE user_id = :id)))";

        $params = [':nextDate' => $date, ':id' => $userId];
        $names = $this->selectAll($stmt, $params);
        return $names;
    }

    //helper method for getting team members for nearest team_date
    private function getNearestTeamCreated(int $userId): ?string {
        $stmt = "SELECT MIN(team_date) AS target_date FROM team WHERE team_id IN
            (SELECT team_id FROM team_members WHERE user_id = :id) AND team_date >= CURDATE()";

        $params = [$userId];
        $row = $this->selectOne($stmt, $params);

        $date = is_array($row) ? ($row['target_date'] ?? null) : $row;
        return $date;
    }
}

<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
class UserModel extends BaseModel
{
    private const COLUMNS = "user_id, user_role, first_name, last_name, email, phone, user_dc, user_status";

    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    public function getAllUsers(): ?array {
        $stmt = "SELECT ". self::COLUMNS ." FROM users";
        $users = $this->selectAll($stmt);
        return $users;
    }

    public function getUserByPhone($phone): ?array {
        $stmt = "SELECT ". self::COLUMNS ." FROM users WHERE phone = :phone";
        $params = [':phone'=>$phone];
        $user = $this->selectOne($stmt,$params);
        return $user;
    }

    public function getUserByEmail($email): ?array {
        $stmt = "SELECT ". self::COLUMNS ." FROM users WHERE email = :email";
        $params = [':email'=>$email];
        $user = $this->selectOne($stmt,$params);
        return $user;
    }

    public function register($data): void {
        $stmt = "INSERT INTO users(first_name, last_name, email, phone, password) VALUES
            (:fName,:lName,:email,:phone,:pass)";

        $params = [':fName'=>$data['first_name'], ':lName'=>$data['last_name'], ':email'=>$data['email'],
                    ':phone'=>$data['phone'], ':pass'=>$data['password']];
        $this->execute($stmt,$params);
    }


    public function login($email, $password): ?array {
        $stmt = "SELECT * FROM users WHERE email = :email AND password = :pass AND user_status = 'active'";
        $params = [':email'=>$email, ':pass'=>$password];
        $user = $this->selectOne($stmt,$params);
        return $user;
    }

    public function changePassword($user, $password) {
        $stmt = "UPDATE users SET
            password = :password
            WHERE user_id = :user_id";
        $params = [':password'=>$password, 'user_id'=>$user['user_id']];
        $this->execute($stmt,$params);
    }

    public function changeEmail($user, $email) {
        $stmt = "UPDATE users SET
            email = :email,
            WHERE user_id = :user_id";
        $params = [':email'=>$email, 'user_id'=>$user['user_id']];
        $this->execute($stmt,$params);
    }

    public function updateInformation($user_id, $data): void {
        $stmt = "UPDATE users SET
            first_name = :first_name,
            last_name = :last_name,
            email = :email,
            phone = :phone,
            password = :password
            WHERE user_id = :user_id";

        $params = [':first_name'=>$data['first_name'],':last_name'=>$data['last_name'],':email'=>$data['email'],':phone'=>$data['phone'],
                    ':password'=>$data['password'], 'user_id'=>$user_id];
        $this->execute($stmt,$params);
    }

    //returns list of first names of nearest team_date team members of given user_id
    public function getTeamMembersByStation($userId): ?array {
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
    private function getNearestTeamCreated($userId): ?string {
        $stmt = "SELECT MIN(team_date) AS target_date FROM team WHERE team_id IN
            (SELECT team_id FROM team_members WHERE user_id = :id) AND team_date >= CURDATE()";

        $params = [$userId];
        $row = $this->selectOne($stmt, $params);

        $date = is_array($row) ? ($row['target_date'] ?? null) : $row;
        return $date;
    }


}

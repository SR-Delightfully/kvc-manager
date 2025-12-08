<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use Exception;

/**
 * class UserModel
 *
 * This class contains all operations for the User table in our database.
 * This includes the authentication, registration, updating, searching,
 * filtering and get team-members
 */

class UserModel extends BaseModel
{
    // Declaring constants for different table types; the former is an expanded view with all details shown,
    // and the latter being a easy to digest version of the table, without data users may not need to see.
    private const COLUMNS_EXPANDED  = "user_id, user_role, first_name, last_name, email, phone, user_dc, user_status";
    private const COLUMNS_CONDENSED = "first_name, last_name, email, phone, user_status";

    public function __construct(PDOService $pDOService)
    {
        parent::__construct($pDOService);
    }

    public function getCondensedUsers(): ?array
    {
        $stmt = "SELECT " . self::COLUMNS_CONDENSED . " FROM users";
        return $this->selectAll($stmt);
    }

    public function getUsers(): ?array
    {
        $stmt = "SELECT " . self::COLUMNS_EXPANDED . " FROM users";
        return $this->selectAll($stmt);
    }

    public function countUsers(): int
    {
        try {
            $stmt = "SELECT COUNT(*) AS total FROM users";
            $row = $this->selectOne($stmt);
            return (int)($row['total'] ?? 0);
        } catch (\Throwable $e) {
            error_log("countUsers() SQL error: " . $e->getMessage());
            return 0;
        }
    }

    public function getEmployees(): ?array
    {
        $stmt = "SELECT " . self::COLUMNS_EXPANDED . " FROM users WHERE user_role = 'EMPLOYEE'";
        return $this->selectAll($stmt);
    }

    public function getAdmins(): ?array
    {
        $stmt = "SELECT user_id, first_name, last_name, email, phone, user_dc, user_status
                 FROM users WHERE user_role = 'ADMIN'";
        return $this->selectAll($stmt);
    }

    public function getUserById($id): ?array {
        $stmt = "SELECT * FROM users WHERE user_id LIKE :user_id";
        $params = [':user_id' => $id];
        $user =  $this->selectOne($stmt, $params);
        return $user === false ? null : $user;
    }

    public function getUserByName($inputName): ?array {

        $inputName = trim($inputName);

        // If full name (first + last)
        if (str_contains($inputName, ' ')) {
            $stmt = "SELECT " . self::COLUMNS_EXPANDED . "
                     FROM users
                     WHERE CONCAT(first_name, ' ', last_name) LIKE :name";
            $params = [':name' => "%$inputName%"];
            return $this->selectOne($stmt, $params);
        }

        // If only first OR last name
        $stmt = "SELECT " . self::COLUMNS_EXPANDED . "
                 FROM users
                 WHERE first_name LIKE :n OR last_name LIKE :n";

        $params = [':n' => "%$inputName%"];

        return $this->selectOne($stmt, $params);
    }

    public function getUserByPhone($phone): ?array
    {
        $stmt = "SELECT * FROM users WHERE phone LIKE :phone";
        $params = [':phone' => $phone];
        $user =  $this->selectOne($stmt, $params);
        return $user === false ? null : $user;
    }

    public function getUserById($id): ?array
    {
        $stmt = "SELECT * FROM users WHERE user_id = :id";
        $params = [':id' => $id];
        $user =  $this->selectOne($stmt, $params);
        return $user == false ? null : $user;
    }

    public function getUserByEmail($email): ?array
    {
        $stmt = "SELECT * FROM users WHERE email = :email";
        $params = [':email' => $email];
        $user = $this->selectOne($stmt, $params);
        return $user === false ? null : $user;
    }

    public function getUserField(string $fieldName, $userId)
    {
        try {
            $stmt = "SELECT :field FROM users WHERE user_id = :userId";
            $params = [':field' => $fieldName, ':userId' => $userId];
            $info = $this->selectOne($stmt, $params);

            return $info == false ? null : $info;
        } catch (Exception $e) {
            print($e->getMessage()." . Please enter a valid field to extract from user with valid ID.");
        }
    }


    public function register($data): void
    {

        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = "INSERT INTO users(first_name, last_name, email, phone, password)
                 VALUES (:fName, :lName, :email, :phone, :pass)";

        $params = [
            ':fName'  => $data['first_name'],
            ':lName'  => $data['last_name'],
            ':email'  => $data['email'],
            ':phone'  => $data['phone'],
            ':pass'   => $passwordHash
        ];

        $this->execute($stmt, $params);
    }

    public function login($email, $password): ?array
    {
        $user = $this->getUserByEmail($email);
        if (!$user) return null;

        if (!password_verify($password, $user['password'])) {
            return null;
        }

        if ($user['user_status'] !== 'active') {
            return null;
        }

        return $user;
    }

    public function changePassword($user, $password)
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = "UPDATE users SET password = :password WHERE user_id = :user_id";
        $params = [
            ':password' => $passwordHash,
            ':user_id'  => $user['user_id']
        ];
        $this->execute($stmt, $params);
    }

    public function changeEmail($user, $email)
    {
        $stmt = "UPDATE users SET email = :email WHERE user_id = :user_id";
        $params = [
            ':email'  => $email,
            ':user_id' => $user['user_id']
        ];
        $this->execute($stmt, $params);
    }

    public function updateInformation($user_id, $data): void
    {

        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = "UPDATE users SET
                    first_name = :first_name,
                    last_name  = :last_name,
                    email      = :email,
                    phone      = :phone,
                    password   = :password
                 WHERE user_id = :user_id";

        $params = [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'password'   => $passwordHash,
            'user_id'    => $user_id
        ];

        try {

            $update = $this->execute($stmt, $params);

            if($update <= 0)
            {
                throw new Exception("Employee(ID: $user_id) update failed.", 1);

            }

        } catch (Exception $e) {
            print($e->getMessage());
        }
    }

    public function createUser($data): int
    {
        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = "INSERT INTO users (user_role, first_name, last_name, email, phone, password, user_dc, user_status) VALUES (employee, :first_name,  :last_name, :email, :phone, :password, current_timestamp(), active)";

        $params = [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'password'   => $passwordHash,
        ];

        try {

            $insert = $this->execute($stmt, $params);

            if($insert <= 0)
            {
                throw new Exception("New Employee insert failed.", 1);

            }

        } catch (Exception $e) {
            print($e->getMessage());
        }

        return $this->lastInsertId();
    }

    public function getTeamMembersByStation($userId): ?array
    {
        $date = $this->getNearestTeamCreated($userId);

        if (!$date) return null;

        $stmt = "SELECT first_name FROM users WHERE user_id IN
                    (SELECT user_id FROM team_members WHERE team_id IN
                        (SELECT team_id FROM team
                         WHERE team_date = :nextDate AND team_id IN
                            (SELECT team_id FROM team_members WHERE user_id = :id)))";

        $params = [
            ':nextDate' => $date,
            ':id'       => $userId
        ];

        return $this->selectAll($stmt, $params);
    }

    private function getNearestTeamCreated($userId): ?string
    {
        $stmt = "SELECT MIN(team_date) AS target_date FROM team WHERE team_id IN
                 (SELECT team_id FROM team_members WHERE user_id = :id)
                 AND team_date >= CURDATE()";

        $params = [':id' => $userId];
        $row = $this->selectOne($stmt, $params);

        return $row['target_date'] ?? null;
    }

    public function verifyCredentials($email, $password): ?array
    {
        $user = $this->getUserByEmail($email);
        if (!$user) return null;

        return password_verify($password, $user['password']) ? $user : null;
    }

    public function terminateUser($id)
    {
        $stmt = "UPDATE users SET user_status = 'terminated' WHERE user_id = :user_id";
        $params = [':user_id' => $id];
        $this->execute($stmt, $params);
    }

    public function search($searchTerm = '', $role = null, $status = null)
    {
        $stmt = "SELECT * FROM users WHERE 1 = 1";
        $params = [];

        if (!empty($searchTerm)) {
            $stmt .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
            $like = '%' . $searchTerm . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        if (!empty($role) && !is_null($role)) {
            $stmt .= " AND user_role = ?";
            $params[] = $role;
        }

        if (!empty($status) && !is_null($status)) {
            $stmt .= " AND user_status = ?";
            $params[] = $status;
        }

        return $this->selectAll($stmt, $params);
    /**
     * Update the first and last names of a specific user
     * @param mixed $userId The id of the user to edit
     * @param mixed $firstName new first name
     * @param mixed $lastName new last name
     * @throws Exception Error in case of update failure
     * @return void the user record wil be updated
     */
    public function updateUserName($userId, $firstName, $lastName)
    {
        $sql = "UPDATE users SET first_name = :fname, last_name = :lname WHERE user_id = :id";

        $update = $this->execute($sql, ["fname" => $firstName, "lname" => $lastName, "id" => $userId]);

        if ($update <= 0) {
            throw new Exception("Could not update the name of this user: id: $userId", 1);
        }
    }

    /**
     * Update the phone number of a specific user
     * @param mixed $userId The id of the user to edit
     * @param mixed $newPhone The new phone number, in the format 123-123-1234 or 1231231234
     * @throws Exception Error in case of update failure
     * @return void the user record wil be updated
     */
    public function updateUserPhone($userId, $newPhone)
    {
        //Accepted format: 1231231234 OR 123-123-1234

        $sql = "UPDATE users SET phone = :phone WHERE user_id = :id";

        $update = $this->execute($sql, ["phone" => $newPhone, "id" => $userId]);

        if ($update <= 0) {
            throw new Exception("Could not update the phone number of this user: id: $userId", 1);
        }
    }

    /**
     * Update the email address of a specific user
     * @param mixed $userId The id of the user to edit
     * @param mixed $newEmail the new email
     * @throws Exception Error in case of update failure
     * @return void the user record wil be updated
     */
    public function updateUserEmail($userId, $newEmil)
    {

        $sql = "UPDATE users SET email = :email WHERE user_id = :id";

        $update = $this->execute($sql, ["email" => $newEmil, "id" => $userId]);

        if ($update <= 0) {
            throw new Exception("Could not update the email of this user: id: $userId", 1);
        }
    }
}

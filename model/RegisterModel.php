<?php

namespace Model;

class RegisterModel {
    private $db;

    public function __construct(DatabaseModel $db) {
        $this->db = $db;
    }

    public function registerUser($username, $password, $repeatPassword): void {
        if ($username && $password && $repeatPassword) {
            if ($this->isCredentialsValid($username, $password, $repeatPassword)) {
                $sql = "INSERT INTO Users (username, password) VALUES ('$username', '$password')";
                mysqli_query($this->db->connectToDatabase(), $sql);
                header("Location: /?");
            }
        }
    }

    private function isCredentialsValid($username, $password, $repeatPassword): bool {
        $minLengthUsername = 3;
        $minLengthPassword = 6;
        return $this->isUsernameAvailable($username) == false
        && strlen($username) >= $minLengthUsername
        && strlen($password) >= $minLengthPassword
            && $password === $repeatPassword;
    }

    private function isUsernameAvailable(string $username): bool {
        $sql = "SELECT username FROM Users WHERE username='$username'";
        $user = mysqli_query($this->db->connectToDatabase(), $sql);
        $usernameTaken = false;

        if ($this->userAlreadyExists($user)) {
            return $usernameTaken = true;
        } else {
            return $usernameTaken = false;
        }
    }

    private function userAlreadyExists($user): bool {
        return $user->num_rows > 0;
    }
}

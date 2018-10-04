<?php

class RegisterModel
{
    private $db;

    public function __construct(DatabaseModel $db)
    {
        $this->db = $db;
    }

    private function userAlreadyExists(mysqli_result $user): bool
    {
        return $user->num_rows > 0;
    }

    public function isUsernameAvailable(string $username): bool
    {
        $sql = "SELECT username FROM Users WHERE username='$username'";
        $user = mysqli_query($this->db->connectToDatabase(), $sql);
        $usernameTaken = false;

        if ($this->userAlreadyExists($user)) {
            return $usernameTaken = true;
        } else {
            return $usernameTaken = false;
        }
    }

    private function isCredentialsValid($username, $password, $repeatPassword): bool
    {
        return $this->isUsernameAvailable($username) == false
        && strlen($username) > 2
        && strlen($password) > 5
            && $password === $repeatPassword;
    }

    public function registerUser($username, $password, $repeatPassword): void
    {
        if ($username && $password && $repeatPassword) {
            if ($this->isCredentialsValid($username, $password, $repeatPassword)) {
                $sql = "INSERT INTO Users (username, password) VALUES ('$username', '$password')";
                mysqli_query($this->db->connectToDatabase(), $sql);
                header("Location: /?");
            }
        }
    }
}

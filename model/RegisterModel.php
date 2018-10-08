<?php

class RegisterModel
{
    private $db;
    private const MIN_LENGTH_USERNAME = 3;
    private const MIN_LENGTH_PASSWORD = 6;

    public function __construct(DatabaseModel $db)
    {
        $this->db = $db;
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

    private function isCredentialsValid($username, $password, $repeatPassword): bool
    {
        return $this->isUsernameAvailable($username) == false
        && strlen($username) >= self::MIN_LENGTH_USERNAME
        && strlen($password) >= self::MIN_LENGTH_PASSWORD
            && $password === $repeatPassword;
    }

    private function isUsernameAvailable(string $username): bool
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

    private function userAlreadyExists(mysqli_result $user): bool
    {
        return $user->num_rows > 0;
    }
}

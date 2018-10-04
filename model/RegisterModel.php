<?php
require_once 'model/DatabaseModel.php';

class RegisterModel
{
    public function __construct()
    {
        $this->db = new DatabaseModel();
    }

    public function doesUserExist($username): bool
    {
        $sql = "SELECT username FROM Users WHERE username='$username'";
        $user = mysqli_query($this->db->connectToDatabase(), $sql);
        $usernameTaken = false;

        if ($user->num_rows > 0) {
            return $usernameTaken = true;
        } else {
            return $usernameTaken = false;
        }
    }

    public function registerUser($username, $password, $repeatPassword): void
    {
        if ($username && $password) {
            if ($this->doesUserExist($username) == false
                && strlen($username) > 2
                && strlen($password) > 5
                && $password === $repeatPassword) {
                $sql = "INSERT INTO Users (username, password) VALUES ('$username', '$password')";
                mysqli_query($this->db->connectToDatabase(), $sql);
            }
        }
    }
}

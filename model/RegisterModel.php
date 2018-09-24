<?php
require_once 'model/DatabaseModel.php';

class RegisterModel
{
    public function __construct()
    {
        $this->db = new DatabaseModel();
    }

    public function userExists($username): bool
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

    /**
     * Attempt to insert the newly created user into the db
     *
     * @param string $username the entered username
     * @param string $password the entered password
     * @return void
     */
    public function registerUser($username, $password, $repeatPassword)
    {
        if ($username && $password) {
            if ($this->userExists($username) == false
                && strlen($username) > 2
                && strlen($password) > 5
                && $password === $repeatPassword) {
                $sql = "INSERT INTO Users (username, password) VALUES ('$username', '$password')";
                mysqli_query($this->db->connectToDatabase(), $sql);
            } else {
                return;
            }
        }
    }
}

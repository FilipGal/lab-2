<?php
require_once 'model/DatabaseModel.php';

class RegisterModel
{
    public function __construct()
    {
        $this->db = new DatabaseModel();
    }

    public function userExists($username)
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
     * //TODO: Fix so users can't register with username or password that are too short
     * @param string $username the entered username
     * @param string $password the entered password
     * @return void
     */
    public function registerUser($username, $password)
    {
        if ($username && $password) {
            if ($this->userExists($username) == false) {
                $sql = "INSERT INTO Users (username, password) VALUES ('$username', '$password')";
                mysqli_query($this->db->connectToDatabase(), $sql);
            }
        }
    }
}

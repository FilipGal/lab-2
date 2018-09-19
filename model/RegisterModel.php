<?php
require_once 'model/DatabaseModel.php';

class RegisterModel
{
    public function __construct()
    {
        $this->db = new DatabaseModel();
    }

    private function registerUserQuery($username, $password)
    {
        return "INSERT INTO Users (username, password) VALUES ('$username', '$password')";
    }

    public function userExists($username)
    {
        $sql = "SELECT username FROM Users WHERE username='$_POST[$username]'";
        $user = mysqli_query($this->db->connectToDatabase(), $sql);
        $usernameTaken = false;

        if ($user->num_rows > 0) {
            return $usernameTaken = true;
        } else {
            return $usernameTaken = false;
        }
    }

    private function addNewUser()
    {
        return;
    }

    /**
     * Attempt to insert the newly created user into the db
     *
     * @param string $username the entered username
     * @param string $password the entered password
     * @return void
     */
    public function registerUser(string $username, string $password)
    {
        if (isset($_POST[$username]) && isset($_POST[$username])) {
            if (!$this->userExists($username)) {
                return;
                //TODO: Add user registration here
                // $this->registerUserQuery($username, $password);
            } else {
                return;
            }
        }
    }
}

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
            $sql = "SELECT username FROM Users WHERE username='$_POST[$username]'";
            $user = mysqli_query($this->db->connectToDatabase(), $sql);
            $userExists = false;

            if ($user->num_rows > 0) {
                $userExists = true;
                var_dump($userExists);
            } else {
                $userExists = false;
                var_dump($userExists);
            }

            if (!$userExists) {
                echo "Available name";
                // $this->registerUserQuery($username, $password);
            } else {
                echo "Unavailable name";
            }
        }
    }
}

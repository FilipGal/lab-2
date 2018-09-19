<?php
require_once 'model/DatabaseModel.php';

class RegisterModel
{
    public function __construct()
    {
        $this->db = new DatabaseModel();
    }

    public function registerUserQuery($username, $password)
    {
        return "INSERT INTO Users (username, password) VALUES ($_POST[$username], $_POST[$password])";
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

            if ($user->num_rows == 0) {
                $this->registerUserQuery($username, $password);
                //TODO: skapa funktion för insert :: $this->insertNewUser
            } else {
                return false;
            }
        }
    }
}

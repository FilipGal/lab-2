<?php

require_once "config/Config.php";

class DatabaseModel
{
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * Attempt to connect to mysql database
     *
     * @return void
     */
    public function connectToDatabase()
    {
        $mysqli = new mysqli(
            $this->config->dbHost(),
            $this->config->dbUser(),
            $this->config->dbPass(),
            $this->config->dbName()
        );
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        } else {
            return $mysqli;
        }
    }

    /**
     * Check if username and password matches from db query
     *
     * @param [type] $username
     * @param [type] $password
     * @return void
     */
    public function validateUserCredentials(string $username, string $password)
    {
        return "SELECT username, password FROM Users WHERE BINARY username='$_POST[$username]' AND BINARY password='$_POST[$password]'";
        exit();
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
            $user = mysqli_query($this->connectToDatabase(), $sql);

            if ($user->num_rows > 0) {
                echo "name taken";
                //TODO: skapa funktion för insert :: $this->insertNewUser
            } else {
                echo "registered";
            }
        }

    }
}

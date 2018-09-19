<?php

require_once "config/Config.php";

//TODO: Split functionality from this class to the separate Login/Register models

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

    public function registerUserQuery($username, $password)
    {
        return "INSERT INTO Users (username, password) VALUES ($_POST[$username], $_POST[$password])";
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

            if ($user->num_rows == 0) {
                $this->registerUserQuery($username, $password);
                //TODO: skapa funktion för insert :: $this->insertNewUser
            } else {
                return false;
            }
        }
    }

    /**
     * Query the database for users
     *
     * @return void
     */
    public function queryUser(string $username, string $password)
    {
        return mysqli_query(
            $this->connectToDatabase(),
            $this->validateUserCredentials($username, $password));
    }
}

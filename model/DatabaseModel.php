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
    }
}

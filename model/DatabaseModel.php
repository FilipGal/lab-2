<?php

require_once "config/Config.php";

class DatabaseModel
{
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * Connect to mysql database
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

        // $mysqli = new mysqli(self::$host, self::$user, self::$pass, self::$name);
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        } else {
            return $mysqli;
        }
    }
}

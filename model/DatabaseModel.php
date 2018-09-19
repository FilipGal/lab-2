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
}

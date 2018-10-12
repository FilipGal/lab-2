<?php

namespace Model;

require_once "config/Config.php";

class DatabaseModel
{

    public function __construct()
    {
        $this->config = new \Config\Config();
    }

    public function connect()
    {
        $mysqli = new \MYSQLi(
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

<?php
class DatabaseModel
{
    private static $host = '127.0.0.1';
    private static $user = 'root';
    private static $pass = '';
    private static $name = '1dv610';

    /**
     * Instantiate mysqli connection
     */
    public function __construct()
    {
        $this->mysqli = new mysqli(self::$host, self::$user, self::$pass, self::$name);
    }

    /**
     * Connect to mysql database
     *
     * @return void
     */
    public function connectToDatabase()
    {
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        } else {
            return $this->mysqli;
        }
    }
}

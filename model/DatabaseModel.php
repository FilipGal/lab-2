<?php
class DatabaseModel
{
    private static $host = '127.0.0.1';
    private static $user = 'root';
    private static $pass = '';
    private static $name = '1dv610';

    /**
     * Connect to mysql database
     *
     * @return void
     */
    public function connectToDatabase()
    {
        $mysqli = new mysqli(self::$host, self::$user, self::$pass, self::$name);
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        } else {
            return $mysqli;
        }
    }
}

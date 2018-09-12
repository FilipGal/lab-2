<?php
class DatabaseModel
{
    private static $host = 'localhost:3306';
    private static $user = 'root';
    private static $pass = '';
    private static $name = '1dv610';

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

    /**
     * Query usernames and IDs from database
     *
     * @return void
     */
    public function queryUsernames()
    {
        $result = $this->mysqli->query("SELECT username, userId FROM Users");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return "id: {$row["userId"]} - Name: {$row["username"]}";
            }
        }
    }
}

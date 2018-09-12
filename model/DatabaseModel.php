<?php
class DatabaseModel
{
    /**
     * Connect to mysql database
     *
     * @return void
     */
    public function connectToDatabase()
    {
        //TODO: pass mysqli params as args
        $mysqli = new mysqli("localhost:3306", "root", "", "1dv610");

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        //TODO: Separate query from the db connection
        $result = $mysqli->query("SELECT username, userId FROM Users");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return "id: {$row["userId"]} - Name: {$row["username"]}";
            }
        }
    }
}

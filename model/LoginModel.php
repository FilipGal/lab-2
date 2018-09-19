<?php
require_once 'DatabaseModel.php';

class LoginModel
{
    public function __construct()
    {
        $this->db = new DatabaseModel();
    }

    /**
     * Check if username and password matches from db query
     *
     * @param [type] $username
     * @param [type] $password
     * @return void
     */
    public function doesUserExist(string $username, string $password)
    {
        return "SELECT username, password FROM Users WHERE BINARY username='$_POST[$username]' AND BINARY password='$_POST[$password]'";
    }

    /**
     * Query the database for users
     *
     * @return void
     */
    public function queryUser(string $username, string $password)
    {
        return mysqli_query(
            $this->db->connectToDatabase(),
            $this->doesUserExist($username, $password));
    }

    /**
     * Shorthand function to check if super-globals are set
     *
     * @param [type] $array the array variable
     * @param [type] $key the key to check for in the array
     * @param [type] $default is set to null
     * @return void
     */
    private function checkIfSet(array $array, string $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    /**
     * Destroys the session, logging the user out
     *
     * @return void
     */
    public function logout(string $param)
    {
        if ($this->checkIfSet($_POST, $param)) {
            $_SESSION = array();
            session_destroy();
        }
    }
}

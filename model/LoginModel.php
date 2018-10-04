<?php
require_once 'DatabaseModel.php';
require_once 'SessionModel.php';

class LoginModel
{
    public function __construct()
    {
        $this->db = new DatabaseModel();
        $this->session = new SessionModel();
    }

    public function attemptLogin($username, $password)
    {
        if ($username && $password){
            if ($this->queryUser($username, $password)->num_rows > 0) {
                $this->session->setLoggedIn(true);
            } else {
                $this->session->setLoggedOut();
            }
        }
    }

    public function doesUserExist(string $username, string $password)
    {
        return "SELECT username, password FROM Users WHERE BINARY username='$username' AND BINARY password='$password'";
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

    public function doLogout(string $logout)
    {
        if ($this->checkIfSet($_POST, $logout)) {
            $_SESSION = array();
            session_destroy();
        }
    }
}

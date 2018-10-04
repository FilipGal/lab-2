<?php
require_once 'SessionModel.php';

class LoginModel
{
    private $db;

    public function __construct(DatabaseModel $db)
    {
        $this->db = $db;
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

    public function queryUser(string $username, string $password)
    {
        return mysqli_query(
            $this->db->connectToDatabase(),
            $this->doesUserExist($username, $password));
    }
}

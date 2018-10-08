<?php

class LoginModel
{
    private $db;
    private $session;

    public function __construct(DatabaseModel $db, SessionModel $session)
    {
        $this->db = $db;
        $this->session = $session;
    }

    public function attemptLogin($username, $password)
    {
        if ($username && $password){
            if ($this->doesUserExist($username, $password)->num_rows > 0) {
                $this->session->setLoggedIn(true);
            } else {
                $this->session->setLoggedOut();
            }
        }
    }
    
    public function doesUserExist(string $username, string $password): mysqli_result
    {
        return mysqli_query(
            $this->db->connectToDatabase(),
            $this->queryUser($username, $password));
    }

    private function queryUser(string $username, string $password): string
    {
        return "SELECT username, password FROM Users WHERE BINARY username='$username' AND BINARY password='$password'";
    }

}

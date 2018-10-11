<?php

namespace Model;

class LoginModel
{
    private $db;
    private $session;

    public function __construct(DatabaseModel $db, SessionModel $session)
    {
        $this->db = $db;
        $this->session = $session;
    }

    public function attemptLogin($username, $password): void
    {
        if ($username && $password) {
            if ($this->correctUserCredentials($username, $password)) {
                $this->session->setLoggedIn(true);
            } else {
                $this->session->setLoggedOut();
            }
        }
    }

    public function correctUserCredentials(string $username, string $password)
    {
        return mysqli_query(
            $this->db->connectToDatabase(),
            $this->queryUser($username, $password))->num_rows > 0;
    }

    private function queryUser(string $username, string $password): string
    {
        return "SELECT username, password FROM Users WHERE BINARY username='$username' AND BINARY password='$password'";
    }

    public function doLogout(): void
    {
        $_SESSION = array();
        session_destroy();
    }

}

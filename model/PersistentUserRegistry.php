<?php

namespace Model;

require_once "config/Config.php";

class PersistentUserRegistry
{

    private $session;

    public function __construct(\Model\SessionModel $session)
    {
        $this->config = new \Config\Config();
        $this->session = $session;
    }

    public function attemptLogin($username, $password)
    {
        if ($username && $password) {
            if ($this->hasUser($username, $password)->num_rows > 0) {
                $this->session->setLoggedIn(true);
            } else {
                $this->session->doLogout();
            }
        }
    }

    public function hasUser(string $username, string $password)
    {
        return mysqli_query(
            $this->connectToDatabase(),
            $this->getUser($username, $password));
    }

    private function getUser(string $username, string $password): string
    {
        return "SELECT username, password FROM Users WHERE BINARY username='$username' AND BINARY password='$password'";
    }

    public function addUser($username, $password, $repeatPassword): void
    {
        if ($username && $password && $repeatPassword) {
            if ($this->isCredentialsValid($username, $password, $repeatPassword)) {
                mysqli_query($this->connectToDatabase(), $this->insertUser($username, $password));
                header("Location: /?");
            }
        }
    }

    private function isCredentialsValid($username, $password, $repeatPassword): bool
    {
        $minLengthUsername = 3;
        $minLengthPassword = 6;
        return $this->isUsernameAvailable($username) == false
        && strlen($username) >= $minLengthUsername
        && strlen($password) >= $minLengthPassword
            && $password === $repeatPassword;
    }

    private function isUsernameAvailable(string $username): bool
    {
        $sql = "SELECT username FROM Users WHERE username='$username'";
        $user = mysqli_query($this->connectToDatabase(), $sql);
        $usernameTaken = false;

        if ($this->userAlreadyExists($user)) {
            return $usernameTaken = true;
        } else {
            return $usernameTaken = false;
        }
    }

    private function insertUser($username, $password)
    {
        return "INSERT INTO Users (username, password) VALUES ('$username', '$password')";
    }

    public function connectToDatabase()
    {
        $mysqli = new \MySQLi(
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

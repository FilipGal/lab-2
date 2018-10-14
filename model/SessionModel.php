<?php

namespace Model;

class SessionModel
{
    private $LOGGED_IN_SESSION_LOCATION = __CLASS__ . 'isLoggedIn';
    private $LOGGED_IN_SESSION_USERNAME = __CLASS__ . 'username';

    public function isLoggedIn(): bool
    {
        return isset($_SESSION[$this->LOGGED_IN_SESSION_LOCATION]);
    }

    public function setLoggedIn(bool $isLoggedIn)
    {
        return $_SESSION[$this->LOGGED_IN_SESSION_LOCATION] = $isLoggedIn;
    }

    public function setLoggedOut()
    {
        unset($_SESSION[$this->LOGGED_IN_SESSION_LOCATION]);
    }

    public function setUsername(string $username)
    {
        return $_SESSION[$this->LOGGED_IN_SESSION_USERNAME] = $username;
    }

    public function getUsername()
    {
        if (isset($_SESSION[$this->LOGGED_IN_SESSION_USERNAME])) {
            return $_SESSION[$this->LOGGED_IN_SESSION_USERNAME];
        }
    }
}

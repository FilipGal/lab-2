<?php

class SessionModel
{
    private static $loggedIn = 'loggedIn';

    public function isUserLoggedIn()
    {
        if (isset($_SESSION[self::$loggedIn])) {
            return $_SESSION[self::$loggedIn];
        }
    }
}

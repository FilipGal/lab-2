<?php

class SessionModel
{
    private static $LOGGED_IN_SESSION_LOCATION = __CLASS__ . 'isLoggedIn';
    private static $sessionUser = 'loggedIn';

    /**
     * Check if the $LOGGED_IN_SESSION_LOCATION is true or false
     *
     * @return boolean
     */
    public function isLoggedIn(): bool
    {
        return isset($_SESSION[self::$LOGGED_IN_SESSION_LOCATION]);
    }

    /**
     * Set the $LOGGED_IN_SESSION_LOCATION variable to true or false
     *
     * @param boolean $isLoggedIn true if logged in, false if not
     * @return void
     */
    public function setLoggedIn(bool $isLoggedIn)
    {
        return $_SESSION[self::$LOGGED_IN_SESSION_LOCATION] = $isLoggedIn;
    }

    /**
     * Unset the current $LOGGED_IN_SESSION_LOCATION variable
     *
     * @return void
     */
    public function setLoggedOut()
    {
        unset($_SESSION[self::$LOGGED_IN_SESSION_LOCATION]);
    }
}

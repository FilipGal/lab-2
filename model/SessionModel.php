<?php

namespace Model;

class SessionModel {
    private static $LOGGED_IN_SESSION_LOCATION = __CLASS__ . 'isLoggedIn';

    public function isLoggedIn(): bool {
        return isset($_SESSION[self::$LOGGED_IN_SESSION_LOCATION]);
    }

    public function setLoggedIn(bool $isLoggedIn) {
        return $_SESSION[self::$LOGGED_IN_SESSION_LOCATION] = $isLoggedIn;
    }

    public function setLoggedOut() {
        unset($_SESSION[self::$LOGGED_IN_SESSION_LOCATION]);
    }
}

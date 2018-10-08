<?php

namespace View;

class LoginView
{
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    private $feedback;
    private $session;

    public function __construct(\View\Feedback $feedback, \Model\SessionModel $session)
    {
        $this->feedback = $feedback;
        $this->session = $session;
    }

    public function setCookie()
    {
        if ($this->keepUserLoggedIn()) {
            setcookie(self::$cookieName, $this->getUsername(), time() + 3600);
            setcookie(self::$cookiePassword, hash('sha256', $this->getPassword()), time() + 3600);
        }
    }

    private function keepUserLoggedIn(): bool
    {
        if (isset($_POST[self::$keep])) {
            return true;
        }
        return false;
    }

    public function getUsername()
    {
        if (isset($_POST[self::$name])) {
            return $_POST[self::$name];
        }
    }

    public function getPassword()
    {
        if (isset($_POST[self::$password])) {
            return $_POST[self::$password];
        }
    }

    public function getCookieName()
    {
        return self::$cookieName;
    }

    public function getCookiePassword()
    {
        return self::$cookiePassword;
    }

    //TODO: What to do with this?
    // public function doLogout()
    // {
    //     if ($this->getLogout()) {
    //         $_SESSION = array();
    //         session_destroy();
    //     }
    // }

    public function getLogout(): bool
    {
        return isset($_POST[self::$logout]);
    }

    private function inputNotEmpty(): bool
    {
        return isset($_POST[self::$name]) && isset($_POST[self::$password]);
    }

    public function generateLoginView(): string
    {
        if ($this->getLogin()) {
            return $this->generateLogoutButtonHTML();
        } else {
            return $this->generateLoginFormHTML();
        }
    }

    public function getLogin(): bool
    {
        return $this->session->isLoggedIn();
    }

    private function generateLogoutButtonHTML(): string
    {
        return '
            <form  method="post" >
                <p id="' . self::$messageId . '">' . $this->displayUserFeedback() . '</p>
                <input type="submit" name="' . self::$logout . '" value="logout"/>
            </form>
        ';
    }

    private function generateLoginFormHTML(): string
    {
        return '
            <form method="post" >
                <fieldset>
                    <legend>Login - enter Username and password</legend>
                    <p id="' . self::$messageId . '">' . $this->displayUserFeedback() . '</p>

                    <label for="' . self::$name . '">Username :</label>
                    <input
                        type="text"
                        id="' . self::$name . '"
                        name="' . self::$name . '"
                        value="' . $this->getUsername() . '"
                    />

                    <label for="' . self::$password . '">Password :</label>
                    <input
                    type="password"
                        id="' . self::$password . '"
                        name="' . self::$password . '"
                    />

                    <label for="' . self::$keep . '">Keep me logged in  :</label>
                    <input
                        type="checkbox"
                        id="' . self::$keep . '"
                        name="' . self::$keep . '"
                    />

                    <input
                        type="submit"
                        name="' . self::$login . '"
                        value="login"
                    />
                </fieldset>
            </form>
        ';
    }

    private function displayUserFeedback(): string
    {
        $message = '';

        if ($this->inputNotEmpty()) {
            if ((empty($this->getUsername()))) {
                return $message = $this->feedback->missingUsername();
            } else if (empty($this->getPassword())) {
                return $message = $this->feedback->missingPassword();
            } else if (empty($this->getUsername()) && empty($this->getPassword())) {
                return $message = $this->feedback->missingUsername();
            } else if ($this->getLogin() && !$this->keepUserLoggedIn()) {
                return $message = $this->feedback->loggedIn();
            } else if ($this->keepUserLoggedIn()) {
                return $message = $this->feedback->loggedInSaveCookie();
            } else {
                return $message = $this->feedback->incorrectCredentials();
            }
        }

        if ($this->getLogout()) {
            return $message = $this->feedback->logOut();
        }
        return $message;
    }
}

<?php

require_once 'Feedback.php';
require_once 'model/LoginModel.php';

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

    public function __construct()
    {
        $this->feedback = new Feedback();
        $this->session = new SessionModel();
        $this->loginModel = new LoginModel();
    }

    private function inputNotEmpty(): bool
    {
        return isset($_POST[self::$name]) && isset($_POST[self::$password]);
    }

    public function getUsername()
    {
        if (isset($_REQUEST[self::$name])) {
            return $_REQUEST[self::$name];
        }
    }

    public function getPassword()
    {
        if (isset($_REQUEST[self::$password])) {
            return $_REQUEST[self::$password];
        }
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

    public function getCookieName()
    {
        return self::$cookieName;
    }

    public function getCookiePassword()
    {
        return self::$cookiePassword;
    }

    public function getLogin(): bool
    {
        return $this->session->isLoggedIn();
    }

    public function getLogout()
    {
        return self::$logout;
    }

    private function generateView(string $message): string
    {
        if ($this->getLogin()) {
            return $this->generateLogoutButtonHTML($message);
        } else {
            return $this->generateLoginFormHTML($message);
        }
    }

    //TODO: Clean this up
    private function provideUserFeedback(): string
    {
        $message = '';

        if ($this->inputNotEmpty()) {
            $username = $_POST[self::$name];
            $password = $_POST[self::$password];

            if ((empty($username))) {
                $message = $this->feedback->missingUsername();
            } else if (empty($password)) {
                $message = $this->feedback->missingPassword();
            } else if (empty($username) && empty($password)) {
                $message = $this->feedback->missingUsername();
            } else if ($this->loginModel->queryUser($username, $password)->num_rows == 0) {
                $message = $this->feedback->incorrectCredentials();
            } else if ($this->getLogin() && !$this->keepUserLoggedIn()) {
                $message = $this->feedback->loggedIn();
            } else if ($this->keepUserLoggedIn()) {
                $message = $this->feedback->loggedInSaveCookie();
            } else {
                $message = '';
            }
        }

        //FIXME: Fix to the message is removed when user press F5
        if (isset($_POST[$this->getLogout()])) {
            $message = $this->feedback->logOut();
        }

        return $this->generateView($message);
    }

    public function renderLoginView(): string
    {
        return $this->provideUserFeedback();
    }

    private function generateLogoutButtonHTML(string $message): string
    {
        return '
            <form  method="post" >
                <p id="' . self::$messageId . '">' . $message . '</p>
                <input type="submit" name="' . self::$logout . '" value="logout"/>
            </form>
        ';
    }

    private function generateLoginFormHTML(string $message): string
    {
        return '
            <form method="post" >
                <fieldset>
                    <legend>Login - enter Username and password</legend>
                    <p id="' . self::$messageId . '">' . $message . '</p>

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
}

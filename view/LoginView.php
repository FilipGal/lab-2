<?php

require_once 'Feedback.php';
require_once 'model/DatabaseModel.php';
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

    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  void BUT writes to standard output and cookies!
     */
    public function renderLoginView()
    {
        return $this->provideUserFeedback();
    }

    private function inputNotEmpty()
    {
        return isset($_POST[self::$name]) && isset($_POST[self::$password]);
    }

    /**
     * Generate a view depending on if the user is logged in or not
     *
     * @param [string] $message
     * @return void
     */
    private function generateView(string $message)
    {
        if ($this->getLogin()) {
            return $this->generateLogoutButtonHTML($message);
        } else {
            return $this->generateLoginFormHTML($message);
        }
    }

    public function setCookie()
    {
        if ($this->keepUserLoggedIn()) {
            setcookie('username', $this->getUsername(), time() + 3600);
            setcookie('password', hash('sha256', $this->getPassword()), time() + 3600);
        }
    }

    /**
     * Keeps the user logged in if requested by checking checkbox
     * //TODO: Set cookie as well
     * @return bool
     */
    private function keepUserLoggedIn(): bool
    {
        if (isset($_POST[self::$keep])) {
            return true;
        }
        return false;
    }

    /**
     * Checks if the user is currently logged in or not
     *
     * @return boolean
     */
    public function getLogin(): bool
    {
        return $this->session->isLoggedIn();
    }

    /**
     * Get logout value
     *
     * @return void
     */
    public function getLogout()
    {
        return self::$logout;
    }

    /**
     * Gets the value of the username, if it's entered
     *
     * @return void
     */
    public function getUsername()
    {
        if (isset($_REQUEST[self::$name])) {
            return $_REQUEST[self::$name];
        }
    }

    /**
     * Gets the value of the password, if it's entered
     *
     * @return void
     */
    public function getPassword()
    {
        if (isset($_REQUEST[self::$password])) {
            return $_REQUEST[self::$password];
        }
    }

    /**
     * Provide users with the appropriate feedback
     * //TODO: Clean this mess up...
     * @return string
     */
    private function provideUserFeedback()
    {

        $message = '';

        if ($this->inputNotEmpty()) {
            $username = $_POST[self::$name];
            $password = $_POST[self::$password];

            if (!$username) {
                $message = $this->feedback->missingUsername();
            } else if (!$password) {
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

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  string BUT writes to standard output!
     */
    private function generateLogoutButtonHTML(string $message): string
    {
        return '
            <form  method="post" >
                <p id="' . self::$messageId . '">' . $message . '</p>
                <input type="submit" name="' . self::$logout . '" value="logout"/>
            </form>
        ';
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  string, BUT writes to standard output!
     */
    private function generateLoginFormHTML($message): string
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

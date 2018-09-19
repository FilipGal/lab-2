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
        $this->attemptLogin();
        $this->loginModel->logout(self::$logout);
        return $this->provideUserFeedback();
    }

    private function formFilled()
    {
        return isset($_POST[self::$name]) && isset($_POST[self::$password]);
    }

    /**
     * Provide users with the appropriate feedback
     * //TODO: Clean this mess up...
     * @return string
     */
    private function provideUserFeedback()
    {

        $message = '';

        if ($this->formFilled()) {
            $username = $_POST[self::$name];
            $password = $_POST[self::$password];

            if (!$username) {
                $message = $this->feedback->missingUsername();
            } else if (!$password) {
                $message = $this->feedback->missingPassword();
            } else if (empty(!$username) && empty($password)) {
                $message = $this->feedback->missingUsername();
            } else if ($this->loginModel->queryUser(self::$name, self::$password)->num_rows == 0) {
                $message = $this->feedback->incorrectCredentials();
            } else if ($this->session->isLoggedIn() && !$this->keepUserLoggedIn()) {
                $message = $this->feedback->loggedIn();
            } else if ($this->keepUserLoggedIn()) {
                $message = $this->feedback->loggedInSaveCookie();
            } else {
                $message = '';
            }
        }
        return $this->generateView($message);
    }

    /**
     * Generate a view depending on if the user is logged in or not
     *
     * @param [type] $message
     * @return void
     */
    private function generateView(string $message)
    {
        if ($this->session->isLoggedIn()) {
            return $this->generateLogoutButtonHTML($message);
        } else {
            return $this->generateLoginFormHTML($message);
        }
    }

    /**
     * Request the entered username
     *
     * @return string the entered username
     */
    private function getRequestUserName()
    {
        if (!empty($_REQUEST[self::$name])) {
            return $_REQUEST[self::$name];
        }
    }

    /**
     * Attempt to login
     *
     * @param [type] $username the entered username
     * @param [type] $password  the entered password
     * @return void
     */
    private function attemptLogin()
    {
        if ($this->formFilled()) {
            if ($this->loginModel->queryUser(self::$name, self::$password)->num_rows > 0) {
                $this->session->setLoggedIn(true);
            } else {
                $this->session->setLoggedOut();
            }
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
     * Gets the value of the username, if it's entered
     *
     * @return void
     */
    private function getUsername()
    {
        if (isset($_POST[self::$name])) {
            return $_POST[self::$name];
        }
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

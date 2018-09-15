<?php

require_once "Feedback.php";
require_once "model/DatabaseModel.php";
require_once "controller/LoginController.php";

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
        $this->db = new DatabaseModel();
        $this->loginController = new LoginController();
    }

    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  void BUT writes to standard output and cookies!
     */
    public function response()
    {
        $this->attemptLogin(self::$name, self::$password);
        return $this->provideUserFeedback();
    }

    /**
     * Provide users with the appropriate feedback
     * //TODO: Clean this mess up...
     * @return string
     */
    private function provideUserFeedback()
    {

        $message = '';

        if (isset($_POST[self::$name]) && isset($_POST[self::$password])) {
            $username = $_POST[self::$name];
            $password = $_POST[self::$password];

            if (!$username) {
                $message = $this->feedback->missingUsername();
            } else if (!$password) {
                $message = $this->feedback->missingPassword();
            } else if (empty(!$username) && empty($password)) {
                $message = $this->feedback->missingUsername();
            } else if (!isset($_SESSION['username'])) {
                $message = $this->feedback->incorrectCredentials();
            } else if (($_SESSION['loggedIn'] == true && !$this->keepUserLoggedIn())) {
                $message = $this->feedback->loggedIn();
            } else if ($this->keepUserLoggedIn()) {
                $message = $this->feedback->loggedInSaveCookie();
            } else {
                $message = '';
            }
        }
        $this->loginController->logout(self::$logout);
        return $this->generateView($message);
    }

    /**
     * Keeps the user logged in if requested by checking checkbox
     * //TODO: Set cookie as well
     * @return bool
     */
    public function keepUserLoggedIn(): bool
    {
        if (isset($_POST[self::$keep])) {
            return true;
        }
        return false;
    }

    /**
     * Generate a view depending on if the user is logged in or not
     *
     * @param [type] $message
     * @return void
     */
    private function generateView(string $message)
    {
        if ($_SESSION['loggedIn'] == true) {
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
    private function attemptLogin(string $username, string $password)
    {
        if (isset($_POST[$username]) && isset($_POST[$username])) {
            $user = mysqli_query(
                $this->db->connectToDatabase(),
                $this->db->validateUserCredentials($username, $password));

            if ($user->num_rows >= 1) {
                $_SESSION['username'] = $username;
                $_SESSION['loggedIn'] = true;
            } else {
                $_SESSION['loggedIn'] = false;
            }
        }
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  string BUT writes to standard output!
     */
    private function generateLogoutButtonHTML($message): string
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
                    <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

                    <label for="' . self::$password . '">Password :</label>
                    <input type="password" id="' . self::$password . '" name="' . self::$password . '" />

                    <label for="' . self::$keep . '">Keep me logged in  :</label>
                    <input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

                    <input type="submit" name="' . self::$login . '" value="login" />
                </fieldset>
            </form>
        ';
    }
}

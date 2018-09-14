<?php

require_once "Feedback.php";
require_once "model/DatabaseModel.php";

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
    }

    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  void BUT writes to standard output and cookies!
     */
    public function response(): string
    {
        $this->attemptLogin(self::$name, self::$password);
        return $this->provideUserFeedback();
    }

    private function checkIfSet($array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    /**
     * Provide users with the appropriate feedback
     *
     * @return string
     */
    private function provideUserFeedback(): string
    {

        $message = '';

        if (isset($_POST[self::$name]) && isset($_POST[self::$password])) {
            if (!$_POST[self::$name]) {
                $message = $this->feedback->missingUsername();
            } else if (!$_POST[self::$password]) {
                $message = $this->feedback->missingPassword();
            } else if (empty(!$_POST[self::$name]) && empty($_POST[self::$password])) {
                $message = $this->feedback->missingUsername();
            } else if ($_SESSION['loggedIn'] == false) {
                $message = $this->feedback->incorrectCredentials();
            } else {
                $message = '';
            }
        }

        $this->destroyUserSession();
        return $this->generateView($message);

    }

    private function generateView($message)
    {
        $response = $this->generateLoginFormHTML($message);

        if (isset($_SESSION['username'])) {
            $response .= $this->generateLogoutButtonHTML($message);
            $message = '';
        } else {
            $response = $this->generateLoginFormHTML($message);
            $this->getRequestUserName();
        }
        return $response;

    }

    /**
     * Destroys the session, logging the user out
     * //TODO: Finish this function
     * @return void
     */
    private function destroyUserSession()
    {
        if ($this->checkIfSet($_POST, self::$logout)) {
            $_SESSION['loggedIn'] = false;
            echo "Destroy session and redirect";
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
    private function attemptLogin($username, $password)
    {
        if (isset($_POST[$username]) && isset($_POST[$username])) {
            $query = "SELECT * FROM Users WHERE BINARY username='$_POST[$username]' AND BINARY password='$_POST[$password]'";

            $result = mysqli_query($this->db->connectToDatabase(), $query);
            if ($result->num_rows >= 1) {
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

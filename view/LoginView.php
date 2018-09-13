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
        $this->db->connectToDatabase();
        $this->db->isUsernameAvailable(self::$name);
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
        return $this->provideUserFeedback();
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
            if (empty($_POST[self::$name])) {
                $message = $this->feedback->missingUsername();
            } else if (empty($_POST[self::$password])) {
                $message = $this->feedback->missingPassword();
            } else if (empty($_POST[self::$name]) && empty($_POST[self::$password])) {
                $message = $this->feedback->missingUsername();
            } else {
                $message = '';
            }
        }

        $response = $this->generateLoginFormHTML($message);
        $this->getRequestUserName();
        //$response .= $this->generateLogoutButtonHTML($message);
        return $response;
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

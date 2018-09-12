<?php

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
        $this->connectToDatabase();
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

        if (empty($_POST[self::$name])) {
            $message = 'Username is missing';
        }

        if (empty($_POST[self::$password])) {
            $message = 'Password is missing';
        }

        $response = $this->generateLoginFormHTML($message);
        $this->getRequestUserName();
        //$response .= $this->generateLogoutButtonHTML($message);
        return $response;
    }

    /**
     * Connect to mysql database
     *
     * @return void
     */
    private function connectToDatabase()
    {
        $mysqli = new mysqli("localhost:3306", "root", "", "1dv610");
        $result = $mysqli->query("SELECT username, userId FROM Users");

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return "id: {$row["userId"]} - Name: {$row["username"]}";
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

    /**
     * Request the entered username
     *
     * @return string the entered username
     */
    private function getRequestUserName()
    {
        $username = $_REQUEST[self::$name];
        if (!empty($username)) {
            return $username;
        }
    }

}

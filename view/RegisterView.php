<?php
class RegisterView
{
    private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';

    /**
     * Called after user clicks the register button
     *
     * @return void
     */
    public function response(): string
    {
        return $this->provideUserFeedback();
    }
    
    private function provideUserFeedback() {
        $message = '';
        return $this->generateRegisterFormHTML($message);
    }

        /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  string, BUT writes to standard output!
     */
    private function generateRegisterFormHTML(string $message): string
    {
        return '
        <h2>Register new user</h2>
            <form method="post" >
                <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                    <p id="' . self::$messageId . '">' . $message . '</p>
                    
                    <label for="' . self::$name . '">Username :</label>
                    <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />
                    <br />
                    <label for="' . self::$password . '">Password :</label>
                    <input type="password" id="' . self::$password . '" name="' . self::$password . '" />
                    <br />
                    <label for="' . self::$passwordRepeat . '">Repeat password :</label>
                    <input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />
                    <br />
                    <input type="submit" name="' . self::$register . '" value="Register" />
                </fieldset>
            </form>
        ';
    }
}

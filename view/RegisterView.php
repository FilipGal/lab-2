<?php

require_once 'model/RegisterModel.php';

class RegisterView
{
    private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';

    public function __construct()
    {
        $this->feedback = new Feedback();
        $this->registerModel = new RegisterModel();
    }

    /**
     * Called after user clicks the register button
     *
     * @return void
     */
    public function renderRegisterView(): string
    {
        $this->registerModel->registerUser($this->getUsername(), $this->getPassword(), $this->getRepeatPassword());
        return $this->provideUserFeedback();
    }

    /**
     * Provides the user with the appropriate feedback depending on the
     * error that occurs
     * @return string
     */
    private function provideUserFeedback(): string
    {
        $message = '';
        if (isset($_POST[self::$name]) && isset($_POST[self::$password])) {
            $username = $_POST[self::$name];
            $password = $_POST[self::$password];

            if (strlen($username) < 3) {
                $message .= $this->feedback->usernameTooShort() . '<br />';
            }

            if (strlen($password) < 6) {
                $message .= $this->feedback->passwordTooShort() . '<br />';
            }

            if (!$this->checkIfUnallowedCharacters()) {
                $message .= $this->feedback->invalidCharacters() . '<br />';
            }

            if ($password != $_POST[self::$passwordRepeat]) {
                $message .= $this->feedback->passwordsNotMatching() . '<br />';
            }

            if ($this->registerModel->userExists($this->getUsername()) == true) {
                $message .= $this->feedback->userExists();
            }
        } else {
            $message = '';
        }
        return $this->generateRegisterFormHTML($message);
    }

    /**
     * Validate user input
     *
     * @return bool
     */
    public function checkIfUnallowedCharacters(): bool
    {
        return preg_match('/^[a-zA-Z0-9]+$/', $_POST[self::$name]);
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

    private function getPassword()
    {
        if (isset($_POST[self::$password])) {
            return $_POST[self::$password];
        }
    }

    private function getRepeatPassword()
    {
        if (isset($_POST[self::$passwordRepeat])) {
            return $_POST[self::$passwordRepeat];
        }
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
                    <input
                        type="text"
                        id="' . self::$name . '"
                        name="' . self::$name . '"
                        value="' . $this->getUsername() . '"
                    />
                    <br />
                    <label for="' . self::$password . '">Password :</label>
                    <input
                        type="password"
                        id="' . self::$password . '"
                        name="' . self::$password . '"
                    />
                    <br />
                    <label for="' . self::$passwordRepeat . '">Repeat password :</label>
                    <input
                        type="password"
                        id="' . self::$passwordRepeat . '"
                        name="' . self::$passwordRepeat . '"
                    />
                    <br />
                    <input type="submit" name="' . self::$register . '" value="Register" />
                </fieldset>
            </form>
        ';
    }
}

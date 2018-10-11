<?php

namespace View;

class RegisterView
{
    private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';

    private $feedback;

    public function __construct(\View\Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    private function displayUserFeedback(): string
    {
        $message = '';
        if ($this->inputNotEmpty()) {
            if ($this->isUsernameTooShort()) {
                $message .= $this->feedback->usernameTooShort() . '<br />';
            }

            if ($this->isPasswordTooShort()) {
                $message .= $this->feedback->passwordTooShort() . '<br />';
            }

            if (!$this->checkIfUnallowedCharacters()) {
                $message .= $this->feedback->invalidCharacters() . '<br />';
            }

            if (!$this->isPasswordMatching()) {
                $message .= $this->feedback->passwordsNotMatching() . '<br />';
            }

            //TODO: Fix this message!
            // if ($this->registerModel->isUsernameAvailable($this->getUsername()) == true) {
            //     $message .= $this->feedback->userExists();
            // }
        } else {
            $message = '';
        }
        return $message;
    }

    private function inputNotEmpty(): bool
    {
        return isset($_POST[self::$name]) && isset($_POST[self::$password]);
    }

    private function isPasswordMatching(): bool
    {
        return $this->getPassword() == $this->getRepeatPassword();
    }

    private function isUsernameTooShort(): bool
    {
        return strlen($this->getUsername()) < 3;
    }

    private function isPasswordTooShort(): bool
    {
        return strlen($this->getPassword()) < 6;
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

    public function getRepeatPassword()
    {
        if (isset($_POST[self::$passwordRepeat])) {
            return $_POST[self::$passwordRepeat];
        }
    }

    private function checkIfUnallowedCharacters(): bool
    {
        return preg_match('/^[a-zA-Z0-9]+$/', $_POST[self::$name]);
    }

    public function generateRegisterView(): string
    {
        return '
        <h2>Register new user</h2>
            <form method="post" >
                <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                    <p id="' . self::$messageId . '">' . $this->displayUserFeedback() . '</p>

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

    public function userWantsToRegister(): bool
    {
        return isset(self::$register);
    }
}

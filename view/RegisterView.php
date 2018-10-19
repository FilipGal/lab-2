<?php

namespace View;

class RegisterView
{
    private $register = 'RegisterView::Register';
    private $name = 'RegisterView::UserName';
    private $password = 'RegisterView::Password';
    private $passwordRepeat = 'RegisterView::PasswordRepeat';
    private $messageId = 'RegisterView::Message';

    private $feedback;

    public function __construct(\View\Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function getUsername()
    {
        if (isset($_POST[$this->name])) {
            return $_POST[$this->name];
        }
    }

    public function getPassword()
    {
        if (isset($_POST[$this->password])) {
            return $_POST[$this->password];
        }
    }

    public function getRepeatPassword()
    {
        if (isset($_POST[$this->passwordRepeat])) {
            return $_POST[$this->passwordRepeat];
        }
    }

    public function generateRegisterView(): string
    {
        return '
        <h2>Register new user</h2>
            <form method="post" >
                <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                    <p id="' . $this->messageId . '">' . $this->displayRegisterFeedback() . '</p>

                    <label for="' . $this->name . '">Username :</label>
                    <input
                        type="text"
                        id="' . $this->name . '"
                        name="' . $this->name . '"
                        value="' . $this->getUsername() . '"
                    />
                    <br />
                    <label for="' . $this->password . '">Password :</label>
                    <input
                        type="password"
                        id="' . $this->password . '"
                        name="' . $this->password . '"
                    />
                    <br />
                    <label for="' . $this->passwordRepeat . '">Repeat password :</label>
                    <input
                        type="password"
                        id="' . $this->passwordRepeat . '"
                        name="' . $this->passwordRepeat . '"
                    />
                    <br />
                    <input type="submit" name="' . $this->register . '" value="Register" />
                </fieldset>
            </form>
        ';
    }

    private function displayRegisterFeedback(): string
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
        } else {
            $message = '';
        }
        return $message;
    }

    private function inputNotEmpty(): bool
    {
        return isset($_POST[$this->name]) && isset($_POST[$this->password]);
    }

    private function isUsernameTooShort(): bool
    {
        $minLengthUsername = 3;
        return strlen($this->getUsername()) < $minLengthUsername;
    }

    private function isPasswordTooShort(): bool
    {
        $minLengthPassword = 6;
        return strlen($this->getPassword()) < $minLengthPassword;
    }

    private function checkIfUnallowedCharacters(): bool
    {
        return strip_tags($_POST[$this->name]);
    }

    private function isPasswordMatching(): bool
    {
        return $this->getPassword() == $this->getRepeatPassword();
    }

    public function userWantsToRegister(): bool
    {
        return isset($this->register);
    }
}

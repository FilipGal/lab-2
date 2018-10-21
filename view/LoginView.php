<?php

namespace View;

class LoginView
{
    private $login = 'LoginView::Login';
    private $logout = 'LoginView::Logout';
    private $name = 'LoginView::UserName';
    private $password = 'LoginView::Password';
    private $cookieName = 'LoginView::CookieName';
    private $cookiePassword = 'LoginView::CookiePassword';
    private $keep = 'LoginView::KeepMeLoggedIn';
    private $messageId = 'LoginView::Message';

    private $feedback;
    private $session;

    public function __construct(\View\Feedback $feedback, \Model\SessionModel $session)
    {
        $this->feedback = $feedback;
        $this->session = $session;
    }

    public function setCookie()
    {
        if ($this->keepUserLoggedIn()) {
            setcookie($this->cookieName, $this->getUsername(), time() + 3600);
            setcookie($this->cookiePassword, hash('sha256', $this->getPassword()), time() + 3600);
        }
    }

    private function generateLogoutButtonHTML(): string
    {
        return '
            <form  method="post" >
                <p id="' . $this->messageId . '">' . $this->displayUserFeedback() . '</p>
                <input type="submit" name="' . $this->logout . '" value="logout"/>
            </form>
        ';
    }

    private function generateLoginFormHTML(): string
    {
        return '
            <form method="post">
                <fieldset>
                    <legend>Login - enter Username and password</legend>
                    <p id="' . $this->messageId . '">' . $this->displayUserFeedback() . '</p>

                    <label for="' . $this->name . '">Username :</label>
                    <input
                        type="text"
                        id="' . $this->name . '"
                        name="' . $this->name . '"
                        value="' . $this->getUsername() . '"
                    />

                    <label for="' . $this->password . '">Password :</label>
                    <input
                    type="password"
                        id="' . $this->password . '"
                        name="' . $this->password . '"
                    />

                    <label for="' . $this->keep . '">Keep me logged in  :</label>
                    <input
                        type="checkbox"
                        id="' . $this->keep . '"
                        name="' . $this->keep . '"
                    />

                    <input
                        type="submit"
                        name="' . $this->login . '"
                        value="login"
                    />
                </fieldset>
            </form>
        ';
    }

    private function displayUserFeedback(): string
    {
        $message = '';

        if ($this->inputNotEmpty()) {
            if ((empty($this->getUsername()))) {
                return $message = $this->feedback->missingUsername();
            } else if (empty($this->getPassword())) {
                return $message = $this->feedback->missingPassword();
            } else if (empty($this->getUsername()) && empty($this->getPassword())) {
                return $message = $this->feedback->missingUsername();
            } else if ($this->isUserLoggedIn() && !$this->keepUserLoggedIn()) {
                return $message = $this->feedback->loggedIn();
            } else if ($this->keepUserLoggedIn()) {
                return $message = $this->feedback->loggedInSaveCookie();
            } else {
                return $message = $this->feedback->incorrectCredentials();
            }
        }

        if ($this->getLogout()) {
            return $message = $this->feedback->logOut();
        }
        return $message;
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

    private function inputNotEmpty(): bool
    {
        return isset($_POST[$this->name]) && isset($_POST[$this->password]);
    }

    private function keepUserLoggedIn(): bool
    {
        if (isset($_POST[$this->keep])) {
            return true;
        }
        return false;
    }

    public function getCookieName(): string
    {
        return $this->cookieName;
    }

    public function getCookiePassword(): string
    {
        return $this->cookiePassword;
    }

    public function getLogout(): bool
    {
        return isset($_POST[$this->logout]);
    }

    public function generateLoginView(): string
    {
        if ($this->isUserLoggedIn()) {
            return $this->generateLogoutButtonHTML();
        } else {
            return $this->generateLoginFormHTML();
        }
    }

    public function isUserLoggedIn(): bool
    {
        return $this->session->isLoggedIn();
    }
}

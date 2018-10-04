<?php

class LoginController
{
    private $v;
    private $m;
    private $s;

    public function __construct(LoginView $v, LoginModel $m, SessionModel $s)
    {
        $this->loginView = $v;
        $this->loginModel = $m;
        $this->sessionModel = $s;
    }

    public function loginResponse()
    {
        if (!$this->isUserLoggedIn()) {
            $this->loginModel->attemptLogin(
                $this->loginView->getUsername(),
                $this->loginView->getPassword()
            );
        } else if ($this->userWantsToLogout()) {
            $this->loginView->doLogout();
        }
    }

    private function isUserLoggedIn(): bool
    {
        return $this->sessionModel->isLoggedIn();
    }

    private function userWantsToLogout()
    {
        return $this->loginView->getLogout();
    }
}

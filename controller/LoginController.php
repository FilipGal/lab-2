<?php

class LoginController
{
    private $v;
    private $m;

    public function __construct(LoginView $v, LoginModel $m)
    {
        $this->loginView = $v;
        $this->loginModel = $m;
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
        return $this->loginView->getLogin();
    }

    private function userWantsToLogout()
    {
        return $this->loginView->getLogout();
    }
}

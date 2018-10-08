<?php

namespace Controller;

class LoginController
{
    private $v;
    private $m;
    private $s;

    public function __construct(\View\LoginView $v, \Model\LoginModel $m, \Model\SessionModel $s)
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
            $this->loginView->setCookie();
        } else {
            $this->sessionModel->doLogout();
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

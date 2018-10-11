<?php

namespace Controller;

class AuthenticationController
{
    private $lv;
    private $lm;
    private $sm;
    private $rv;
    private $rm;

    public function __construct(
        \View\LoginView $lv,
        \Model\LoginModel $lm,
        \Model\SessionModel $sm,
        \View\RegisterView $rv,
        \Model\RegisterModel $rm
    ) {
        $this->loginView = $lv;
        $this->loginModel = $lm;
        $this->sessionModel = $sm;
        $this->registerView = $rv;
        $this->registerModel = $rm;
    }

    public function route()
    {
        $this->loginResponse();
        $this->registerResponse();
    }

    private function loginResponse()
    {
        if (!$this->isUserLoggedIn()) {
            $this->loginModel->attemptLogin(
                $this->loginView->getUsername(),
                $this->loginView->getPassword()
            );
            $this->loginView->setCookie();
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

    private function registerResponse(): void
    {
        if ($this->registerView->userWantsToRegister()) {
            $this->registerModel->registerUser(
                $this->registerView->getUsername(),
                $this->registerView->getPassword(),
                $this->registerView->getRepeatPassword()
            );
        }
    }
}

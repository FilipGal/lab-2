<?php

namespace Controller;

class LoginController
{
    private $v;
    private $pur;
    private $s;

    public function __construct(\View\LoginView $v, \Model\PersistentUserRegistry $pur, \Model\SessionModel $s)
    {
        $this->loginView = $v;
        $this->pur = $pur;
        $this->sessionModel = $s;
    }

    public function loginResponse()
    {
        if (!$this->isUserLoggedIn()) {
            $this->pur->attemptLogin(
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

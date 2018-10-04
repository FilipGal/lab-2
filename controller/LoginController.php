<?php

require_once 'BaseController.php';

class LoginController extends BaseController
{
    private $v;
    public function __construct(LoginView $v)
    {
        parent::__construct();
        $this->loginView = $v;
    }

    public function loginResponse()
    {
        if (!$this->isUserLoggedIn()) {
            $this->loginModel->attemptLogin(
                $this->loginView->getUsername(),
                $this->loginView->getPassword()
            );
        } else if ($this->userWantsToLogout()) {
            $this->loginModel->doLogout($this->userWantsToLogout());
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

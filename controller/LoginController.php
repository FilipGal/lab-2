<?php

require_once 'BaseController.php';
require_once 'view/LoginView.php';

class LoginController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->loginView = new LoginView();
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

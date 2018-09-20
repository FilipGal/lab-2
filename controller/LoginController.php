<?php

require_once 'model/LoginModel.php';
require_once 'view/LoginView.php';

class LoginController
{
    public function __construct()
    {
        $this->loginView = new LoginView();
        $this->loginModel = new LoginModel();
    }

    public function loginResponse()
    {
        if ($this->userWantsToLogin()) {
            $this->loginView->attemptLogin();
        }
    }

    private function userWantsToLogin()
    {
        return $this->loginView->getLogin();
    }
}

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
        if (!$this->userWantsToLogin()) {
            $this->loginModel->attemptLogin(
                $this->loginView->getUsername(),
                $this->loginView->getPassword()
            );
        }
    }

    private function userWantsToLogin()
    {
        return $this->loginView->getLogin();
    }
}

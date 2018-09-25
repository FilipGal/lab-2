<?php

require_once 'model/LoginModel.php';
require_once 'model/RegisterModel.php';
require_once 'model/SessionModel.php';

class BaseController
{
    public function __construct()
    {
        $this->loginModel = new LoginModel();
        $this->registerModel = new RegisterModel();
        $this->sessionModel = new SessionModel();
    }
}

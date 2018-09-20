<?php

require_once 'model/LoginModel.php';
require_once 'model/SessionModel.php';

class BaseController
{
    protected $loginModel;
    protected $sessionModel;

    public function __construct()
    {
        $this->loginModel = new LoginModel();
        $this->sessionModel = new SessionModel();
    }
}

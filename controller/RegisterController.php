<?php

require_once "BaseController.php";
require_once "view/RegisterView.php";

class RegisterController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->registerView = new RegisterView();
    }
}

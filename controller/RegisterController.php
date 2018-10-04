<?php

require_once "BaseController.php";
require_once "view/RegisterView.php";

class RegisterController extends BaseController
{
    private $v;

    public function __construct(RegisterView $v)
    {
        parent::__construct();
        $this->registerView = $v;
    }
}

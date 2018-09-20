<?php
require_once 'view/LoginView.php';
require_once 'view/LayoutView.php';
require_once 'view/RegisterView.php';
require_once 'LoginController.php';
require_once 'BaseController.php';

class MainController extends Basecontroller
{

    public function __construct()
    {
        parent::__construct();
        $this->loginView = new LoginView();
        $this->layoutView = new LayoutView();
        $this->registerView = new RegisterView();
        $this->loginController = new LoginController();
    }

    public function render()
    {
        $this->loginController->loginResponse();
        $this->layoutView->renderLayoutView(
            $this->loginView,
            $this->registerView
        );
    }
}

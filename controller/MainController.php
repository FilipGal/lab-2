<?php
require_once 'LoginController.php';
require_once 'BaseController.php';

class MainController extends BaseController
{
    private $loginView;
    private $layoutView;
    private $registerView;

    public function __construct(
        LoginView $loginView,
        LayoutView $layoutView,
        RegisterView $registerView
    ) {
        parent::__construct();
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
        $this->registerView = $registerView;
        $this->loginController = new LoginController($loginView);
    }

    public function render()
    {
        $this->loginView->setCookie();
        $this->loginController->loginResponse();
        $this->layoutView->renderLayoutView(
            $this->loginView,
            $this->registerView
        );
    }
}

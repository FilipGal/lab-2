<?php
require_once 'LoginController.php';
require_once 'RegisterController.php';

class MainController
{
    private $loginView;
    private $layoutView;
    private $registerView;

    private $loginModel;

    public function __construct(
        LoginView $loginView,
        LayoutView $layoutView,
        RegisterView $registerView,
        LoginModel $loginModel
    ) {
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
        $this->registerView = $registerView;

        $this->loginController = new LoginController($loginView, $loginModel);
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

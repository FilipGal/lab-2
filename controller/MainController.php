<?php
require_once 'LoginController.php';
require_once 'RegisterController.php';

class MainController
{
    private $loginView;
    private $layoutView;
    private $registerView;

    private $loginModel;
    private $registerModel;

    public function __construct(
        LoginView $loginView,
        LayoutView $layoutView,
        RegisterView $registerView,
        LoginModel $loginModel,
        RegisterModel $registerModel
    ) {
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
        $this->registerView = $registerView;

        $this->loginController = new LoginController($loginView, $loginModel);
        $this->registerController = new RegisterController($registerView, $registerModel);
    }

    public function render()
    {
        $this->loginView->setCookie();
        $this->loginController->loginResponse();
        $this->registerController->registerResponse();
        $this->layoutView->renderLayoutView(
            $this->loginView,
            $this->registerView
        );
    }
}

<?php

class MainController
{
    private $loginView;
    private $layoutView;
    private $registerView;

    private $loginModel;
    private $registerModel;

    private $loginController;
    private $registerController;

    public function __construct(
        LoginView $loginView,
        LayoutView $layoutView,
        RegisterView $registerView,
        LoginModel $loginModel,
        RegisterModel $registerModel,
        LoginController $loginController,
        RegisterController $registerController
    ) {
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
        $this->registerView = $registerView;

        $this->loginController = $loginController;
        $this->registerController = $registerController;
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

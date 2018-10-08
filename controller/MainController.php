<?php

class MainController
{
    private $loginModel;
    private $registerModel;
    private $sessionModel;
    
    private $loginView;
    private $layoutView;
    private $registerView;

    private $loginController;
    private $registerController;


    public function __construct(
        LoginModel $loginModel,
        RegisterModel $registerModel,
        SessionModel $sessionModel,
        LoginView $loginView,
        LayoutView $layoutView,
        RegisterView $registerView,
        LoginController $loginController,
        RegisterController $registerController
    ) {
        $this->sessionModel = $sessionModel;
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
            $this->registerView,
            $this->sessionModel->isLoggedIn()
        );
    }
}

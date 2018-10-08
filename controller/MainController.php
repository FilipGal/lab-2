<?php

class MainController {
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
        LayoutView $layoutView,
        LoginController $loginController,
        RegisterController $registerController
    ) {
        $this->sessionModel = $sessionModel;
        $this->layoutView = $layoutView;
        $this->loginController = $loginController;
        $this->registerController = $registerController;
    }

    public function render() {
        $this->loginController->loginResponse();
        $this->registerController->registerResponse();
        $this->layoutView->renderLayoutView(
            $this->sessionModel->isLoggedIn()
        );
    }
}

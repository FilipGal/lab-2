<?php

namespace Controller;

// class MainController
// {
//     private $loginModel;
//     private $registerModel;
//     private $sessionModel;

//     private $loginView;
//     private $layoutView;
//     private $registerView;

//     private $loginController;
//     private $registerController;

//     public function __construct(
//         \Model\LoginModel $loginModel,
//         \Model\RegisterModel $registerModel,
//         \Model\SessionModel $sessionModel,
//         \View\LayoutView $layoutView,
//         \Controller\LoginController $loginController,
//         \Controller\RegisterController $registerController
//     ) {
//         $this->sessionModel = $sessionModel;
//         $this->layoutView = $layoutView;
//         $this->loginController = $loginController;
//         $this->registerController = $registerController;
//     }

//     public function render()
//     {
//         $this->loginController->loginResponse();
//         $this->registerController->registerResponse();
//         $this->layoutView->renderLayoutView(
//             $this->sessionModel->isLoggedIn()
//         );
//     }
// }

class MainController
{
    private $sessionModel;
    private $layoutView;
    private $loginController;
    private $registerController;

    public function __construct(
        \Model\SessionModel $sessionModel,
        \View\LayoutView $layoutView,
        \Controller\LoginController $loginController,
        \Controller\RegisterController $registerController
    ) {
        $this->sessionModel = $sessionModel;
        $this->layoutView = $layoutView;
        $this->loginController = $loginController;
        $this->registerController = $registerController;
    }

    public function render()
    {
        $this->loginController->loginResponse();
        $this->registerController->registerResponse();
        $this->layoutView->renderLayoutView(
            $this->sessionModel->isLoggedIn()
        );
    }
}

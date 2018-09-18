<?php
require_once 'model/SessionModel.php';
require_once 'view/LoginView.php';
require_once 'view/LayoutView.php';
require_once 'view/RegisterView.php';

class MainController
{

    public function __construct()
    {
        $this->loginView = new LoginView();
        $this->layoutView = new LayoutView();
        $this->registerView = new RegisterView();
        $this->session = new SessionModel();
    }

    public function render()
    {
        $this->layoutView->renderLayoutView(
            $this->session->isLoggedIn(),
            // $this->loginView->isLoggedIn(),
            $this->loginView,
            $this->registerView
        );
    }
}

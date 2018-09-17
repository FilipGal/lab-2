<?php
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
    }

    public function render()
    {
        $this->layoutView->renderLayoutView(
            $this->loginView->isLoggedIn(),
            $this->loginView,
            $this->registerView
        );
    }

}

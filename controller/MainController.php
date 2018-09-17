<?php
require_once 'view/LoginView.php';
require_once 'view/LayoutView.php';
require_once 'view/RegisterView.php';
require_once 'model/SessionModel.php';

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
            $this->loginView->userLogsIn(),
            $this->loginView,
            $this->registerView
        );
    }
}

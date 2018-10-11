<?php

namespace Controller;

class MainController
{
    private $sessionModel;
    private $layoutView;
    private $auth;

    public function __construct(
        \Model\SessionModel $sessionModel,
        \View\LayoutView $layoutView,
        \Controller\AuthenticationController $auth
    ) {
        $this->sessionModel = $sessionModel;
        $this->layoutView = $layoutView;
        $this->auth = $auth;
    }

    public function render(): void
    {
        $this->auth->route();
        $this->layoutView->renderLayoutView($this->sessionModel->isLoggedIn());
    }
}

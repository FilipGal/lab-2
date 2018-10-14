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
        \Controller\AuthenticationController $auth,
        \Controller\SubmissionController $sc
    ) {
        $this->sessionModel = $sessionModel;
        $this->layoutView = $layoutView;
        $this->auth = $auth;
        $this->sc = $sc;
    }

    public function render(): void
    {
        $this->sc->submitPost();
        $this->auth->route();
        $this->layoutView->renderLayoutView($this->sessionModel->isLoggedIn());
    }
}

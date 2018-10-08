<?php
namespace View;

require_once 'view/DateTimeView.php';

class LayoutView
{
    private $v;
    private $rv;

    private $getRegister = 'register';

    public function __construct(\View\LoginView $v, \View\RegisterView $rv)
    {
        $this->date = new DateTimeView();
        $this->v = $v;
        $this->rv = $rv;
    }

    public function renderLayoutView(bool $isLoggedIn)
    {
        echo '<!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <title>Login Example</title>
            </head>
            <body>
            <h1>Assignment 2</h1>
            ' . $this->navigationLink($isLoggedIn) . '
                ' . $this->renderIsLoggedIn($isLoggedIn) . '
                <div class="container">
                    ' . $this->renderView($this->v, $this->rv) . '
                    ' . $this->renderDateTime() . '
                </div>
            </body>
        </html>
    ';
    }

    private function navigationLink(bool $isLoggedIn)
    {
        if ($this->userClickedRegisterLink()) {
            return '<a href="?">Back to login</a>';
        } else if (!$isLoggedIn) {
            return '<a href="?register">Register a new user</a>';
        }
    }

    private function renderView(): string
    {
        if ($this->userClickedRegisterLink()) {
            return $this->rv->generateRegisterView();
        } else {
            return $this->v->generateLoginView();
        }
    }

    private function userClickedRegisterLink(): bool
    {
        return isset($_GET[$this->getRegister]);
    }

    private function renderDateTime(): string
    {
        return $this->date->dateTime();
    }

    private function renderIsLoggedIn(bool $isLoggedIn): string
    {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        } else {
            return '<h2>Not logged in</h2>';
        }
    }
}

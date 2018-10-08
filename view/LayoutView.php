<?php
require_once 'view/DateTimeView.php';

class LayoutView
{

    public function __construct()
    {
        $this->date = new DateTimeView();
    }

    public function renderLayoutView(LoginView $v, RegisterView $rv, bool $isLoggedIn)
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
                    ' . $this->renderView($v, $rv) . '

                    ' . $this->renderDateTime() . '
                </div>
            </body>
        </html>
    ';
    }

    private function renderView(LoginView $v, RegisterView $rv): string
    {
        if ($this->userClicksRegisterLink()) {
            return $rv->renderRegisterView();
        } else {
            return $v->renderLoginView();
        }
    }

    private function userClicksRegisterLink(): bool
    {
        return isset($_GET['register']);
    }

    private function navigationLink(bool $isLoggedIn)
    {
        if ($this->userClicksRegisterLink()) {
            return '<a href="?">Back to login</a>';
        } else if (!$isLoggedIn) {
            return '<a href="?register">Register a new user</a>';
        }
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

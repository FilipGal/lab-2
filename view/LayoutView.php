<?php
require_once 'view/DateTimeView.php';

class LayoutView
{

    private $session;

    public function __construct(SessionModel $session)
    {
        $this->date = new DateTimeView();
        $this->session = $session;
    }

    public function renderLayoutView(LoginView $v, RegisterView $rv)
    {
        //TODO: Move navigation to controller
        $page = null;
        $nav = null;

        if (isset($_GET['register'])) {
            $page = $rv->renderRegisterView();
            $nav = '<a href="?">Back to login</a>';
        } else {
            $page = $v->renderLoginView();

            if (!$this->session->isLoggedIn()) {
                $nav = '<a href="?register">Register a new user</a>';
            }
        }

        echo '<!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <title>Login Example</title>
            </head>
            <body>
            <h1>Assignment 2</h1>
            ' . $nav . '
                ' . $this->renderIsLoggedIn() . '

                <div class="container">
                    ' . $page . '

                    ' . $this->renderDateTime() . '
                </div>
            </body>
        </html>
    ';
    }

    private function renderDateTime(): string
    {
        return $this->date->dateTime();
    }

    private function renderIsLoggedIn(): string
    {
        if ($this->session->isLoggedIn()) {
            return '<h2>Logged in</h2>';
        } else {
            return '<h2>Not logged in</h2>';
        }
    }
}

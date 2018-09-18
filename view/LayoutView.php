<?php
require_once 'view/DateTimeView.php';
require_once 'model/SessionModel.php';

class LayoutView
{

    public function __construct()
    {
        $this->date = new DateTimeView();
        $this->session = new SessionModel();
    }

    /**
     * Renders the layout view
     *
     * @param boolean $isLoggedIn
     * @param LoginView $v
     * @param RegisterView $rv
     * @return void
     */
    public function renderLayoutView(LoginView $v, RegisterView $rv)
    {
        $page;
        if ($_SERVER['REQUEST_URI'] == '/?register') {
            $page = $rv->renderRegisterView();
        } else {
            $page = $v->renderLoginView();
        }

        echo '<!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <title>Login Example</title>
            </head>
            <body>
                <h1>Assignment 2</h1>
                ' . $this->renderIsLoggedIn() . '

                <div class="container">
                    ' . $page . '

                    ' . $this->renderDateTime() . '
                </div>
            </body>
        </html>
    ';
    }

    /**
     * Render the datetime view
     *
     * @return void
     */
    private function renderDateTime()
    {
        return $this->date->dateTime();
    }

    /**
     * Renders a header depending on if the user is logged in or not
     * //TODO: Fix this crazy ugly navigation
     * @param boolean $isLoggedIn
     * @return string
     */
    private function renderIsLoggedIn(): string
    {
        if ($this->session->isLoggedIn()) {
            return '<h2>Logged in</h2>';
        } else {
            if ($_SERVER['REQUEST_URI'] != '/?register') {
                return '<a href="?register">Register a new user</a>
                        <br />
                        <h2>Not logged in</h2>';
            } else {
                return '<a href="/">Back to login</a>
                        <br />
                        <h2>Not logged in</h2>';
            }
        }
    }
}

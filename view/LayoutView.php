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
     * @param LoginView $v
     * @param RegisterView $rv
     * @return void
     */
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

    /**
     * Render the datetime view
     *
     * @return string
     */
    private function renderDateTime(): string
    {
        return $this->date->dateTime();
    }

    /**
     * Renders a header depending on if the user is logged in or not
     * 
     * @param boolean $isLoggedIn
     * @return string
     */
    private function renderIsLoggedIn(): string
    {
        if ($this->session->isLoggedIn()) {
            return '<h2>Logged in</h2>';
        } else {
            return '<h2>Not logged in</h2>';
        }
    }
}

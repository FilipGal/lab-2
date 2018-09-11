<?php

class LayoutView
{

    private $date;

    function __construct () {
        $this->date = new DateTimeView();
    }

    public function renderLayoutView($isLoggedIn, LoginView $v)
    {
        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '

          <div class="container">
              ' . $v->response() . '

              ' . $this->renderDateTime() . '
          </div>
         </body>
      </html>
    ';
    }

    private function renderDateTime () {
        return $this->date->dateTime();
    }

    private function renderIsLoggedIn($isLoggedIn): string
    {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        } else {
            return '<a href="?register">Register a new user</a>
                    <br />
                    <h2>Not logged in</h2>';
        }
    }
}

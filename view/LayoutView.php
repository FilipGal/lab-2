<?php
namespace View;

require_once 'view/DateTimeView.php';

class LayoutView
{
    private $v;
    private $rv;

    public function __construct(\View\LoginView $v, \View\RegisterView $rv, \View\SubmissionForm $sf)
    {
        $this->date = new DateTimeView();
        $this->v = $v;
        $this->rv = $rv;
        $this->sf = $sf;
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
                    ' . $this->shouldRenderPosts($isLoggedIn) . '
                    ' . $this->shouldRenderSubmissionForm($isLoggedIn) . '
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

    private function shouldRenderPosts(bool $isLoggedIn)
    {
        if ($isLoggedIn) {
            return $this->sf->renderSubmittedPosts();
        }
    }

    private function shouldRenderSubmissionForm(bool $isLoggedIn)
    {
        if ($isLoggedIn) {
            return $this->sf->renderSubmissionInput();
        }
    }

    private function userClickedRegisterLink(): bool
    {
        return isset($_GET['register']);
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

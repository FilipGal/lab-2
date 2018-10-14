<?php

namespace View;

class SubmissionView
{
    private $submission = 'Text';
    private $post = 'submit';

    public function __construct(\Model\SubmissionModel $sm)
    {
        $this->sm = $sm;
    }

    public function renderSubmittedPosts()
    {
        return '
            <fieldset>
                <legend><h3>Write something!</h3></legend>
                ' . $this->renderPosts() . '
                <br/>
                ' . $this->renderSubmissionInput() . '
            </fieldset>
        ';
    }

    private function renderPosts()
    {
        $comment = "";
        foreach ($this->sm->fetchPosts() as $post) {
            $comment .= '
                <fieldset>
                    <legend><h3>' . $post->getAuthor() . '</h3></legend>
                    ' . $post->getPost() . '
                </fieldset>
            ';
        }
        return $comment;
    }

    private function renderSubmissionInput()
    {
        return '
            <form method="post">
                <input
                    type="text"
                    name="' . $this->submission . '"
                />
                <br/>

                <input
                    type="submit"
                    name="' . $this->post . '"
                    value="Submit post"
                />
            </form>
        ';
    }

    public function getPostValue()
    {
        if (isset($_POST[$this->submission])) {
            return $_POST[$this->submission];
        }
    }

    public function userRequestPost()
    {
        if (isset($_POST[$this->post])) {
            return ($_POST[$this->post]);
        }
    }
}
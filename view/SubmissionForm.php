<?php

namespace View;

class SubmissionForm
{
    private $submissionText = 'Text';
    private $post = 'Post';

    public function __construct()
    {
    }

    public function renderSubmittedPosts()
    {
        return '
            <fieldset>
                <p>Posts will go here</p>
            </fieldset>
        ';
    }

    public function renderSubmissionInput()
    {
        return '
        <h3>Write something!</h3>
            <form method="post">
                <input
                    type="text"
                    name="' . $this->submissionText . '"
                    value="' . $this->getSubmissionInput() . '"
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

    private function getSubmissionInput()
    {
        if (isset($_POST[$this->submissionText])) {
            return $_POST[$this->submissionText];
        }
    }
}

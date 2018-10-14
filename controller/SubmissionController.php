<?php

namespace Controller;

class SubmissionController
{
    public function __construct(\View\SubmissionView $sv, \Model\SubmissionModel $sm, \Model\SessionModel $session)
    {
        $this->sv = $sv;
        $this->sm = $sm;
        $this->session = $session;
    }

    public function submitPost()
    {
        if ($this->sv->userRequestPost()) {
            {
                try {
                    $this->sm->postSubmission($this->sv->getPostValue(), $this->session->getLoggedInUsername());
                } catch (\StringTooLongException $e) {
                    return $e;
                }
            }
        }
    }
}

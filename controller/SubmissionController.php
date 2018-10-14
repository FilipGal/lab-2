<?php

namespace Controller;

class SubmissionController
{
    public function __construct(\View\SubmissionView $sv, \Model\SubmissionModel $sm)
    {
        $this->sv = $sv;
        $this->sm = $sm;
    }

    //TODO: Fix Post/Redirect/Get
    public function submitPost()
    {
        if ($this->sv->userRequestPost()) {
            {
                try {
                    $this->sm->postSubmission($this->sv->getSubmissionInput());
                } catch (\StringTooLongException $e) {
                    return $e;
                }
            }
        }
    }
}

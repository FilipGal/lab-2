<?php

namespace Controller;

class SubmissionController
{
    public function __construct(\View\SubmissionView $sf, \Model\SubmissionModel $sm)
    {
        $this->sf = $sf;
        $this->sm = $sm;
    }
}

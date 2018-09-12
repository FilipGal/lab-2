<?php
class Feedback
{

    /**
     * Display an error message if no username is entered
     *
     * @return string
     */
    public function missingUsername(): string
    {
        return 'Username is missing';
    }

    /**
     * Display an error message if no password is entered
     *
     * @return string
     */
    public function missingPassword(): string
    {
        return 'Password is missing';
    }
}
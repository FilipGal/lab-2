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

    /**
     * Display an error message if incorrect credentials is entered
     *
     * @return string
     */
    public function incorrectCredentials(): string
    {
        return 'Wrong name or password';
    }

    public function loggedIn(): string
    {
        return 'Welcome';
    }

    public function loggedInSaveCookie(): string
    {
        return 'Welcome and you will be remembered';
    }

    public function logOut(): string
    {
        return 'Bye bye';
    }
}

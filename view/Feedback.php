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

    /**
     * Display welcome message is user logs in
     *
     * @return string
     */
    public function loggedIn(): string
    {
        return 'Welcome';
    }

    /**
     * Displays welcome message if user logs in and decides to save the cookie
     *
     * @return string
     */
    public function loggedInSaveCookie(): string
    {
        return 'Welcome and you will be remembered';
    }

    /**
     * Displays a message to the user when she logs out
     *
     * @return string
     */
    public function logOut(): string
    {
        return 'Bye bye';
    }
}

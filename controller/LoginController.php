<?php
class LoginController
{
    /**
     * Cleaner function to check if values are set
     *
     * @param [type] $array the array variable
     * @param [type] $key the key to check for in the array
     * @param [type] $default is set to null
     * @return void
     */
    public function checkIfSet($array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    /**
     * Destroys the session, logging the user out
     * //TODO: Finish this function
     * @return void
     */
    public function destroyUserSession($param)
    {
        if ($this->checkIfSet($_POST, $param)) {
            $_SESSION['loggedIn'] = false;
            session_destroy();
        }
    }
}

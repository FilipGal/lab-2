<?php

if (!isset($_SESSION)) {
    session_start();
}

//INCLUDE THE FILES NEEDED...
require_once 'view/LoginView.php';
require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';
require_once 'view/RegisterView.php';

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

function isLoggedIn (): bool {
    if (isset($_SESSION['loggedIn'])) {
        if ($_SESSION['loggedIn'] == true) {
            return true;
        }
    }
    return false;
}

//CREATE OBJECTS OF THE VIEWS
$loginView = new LoginView();
$layoutView = new LayoutView();
$registerView = new RegisterView();

$layoutView->renderLayoutView(isLoggedIn(), $loginView, $registerView);

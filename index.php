<?php
require_once 'controller/MainController.php';
require_once 'view/LoginView.php';
require_once 'view/LayoutView.php';
require_once 'view/RegisterView.php';

if (!isset($_SESSION)) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$loginView = new LoginView();
$layoutView = new LayoutView();
$registerView = new RegisterView();

$c = new MainController($loginView, $layoutView, $registerView);

$c->render();

<?php
require_once 'controller/MainController.php';
require_once 'view/LoginView.php';
require_once 'view/LayoutView.php';
require_once 'view/RegisterView.php';

require_once 'model/DatabaseModel.php';
require_once 'model/RegisterModel.php';
require_once 'model/LoginModel.php';

if (!isset($_SESSION)) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$db = new DatabaseModel();
$loginView = new LoginView();
$layoutView = new LayoutView();
$registerView = new RegisterView();

$loginModel = new LoginModel($db);
$registerModel = new RegisterModel($db);

$c = new MainController($loginView, $layoutView, $registerView, $loginModel, $registerModel);

$c->render();

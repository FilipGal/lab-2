<?php

require_once 'model/DatabaseModel.php';
require_once 'model/SessionModel.php';
require_once 'model/LoginModel.php';
require_once 'model/RegisterModel.php';

require_once 'view/Feedback.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';
require_once 'view/LayoutView.php';

require_once 'controller/LoginController.php';
require_once 'controller/RegisterController.php';
require_once 'controller/MainController.php';

if (!isset($_SESSION)) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$db = new \Model\DatabaseModel();
$sessionModel = new \Model\SessionModel();
$loginModel = new \Model\LoginModel($db, $sessionModel);
$registerModel = new \Model\RegisterModel($db);

$feedback = new \view\Feedback();
$loginView = new \view\LoginView($feedback, $sessionModel);
$registerView = new \view\RegisterView($feedback);
$layoutView = new \view\LayoutView($loginView, $registerView);

$loginController = new \Controller\LoginController($loginView, $loginModel, $sessionModel);
$registerController = new \Controller\RegisterController($registerView, $registerModel);

$c = new \Controller\MainController(
    $loginModel,
    $registerModel,
    $sessionModel,
    $layoutView,
    $loginController,
    $registerController
);

$c->render();

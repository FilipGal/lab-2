<?php

require_once 'model/DatabaseModel.php';
require_once 'model/SessionModel.php';
require_once 'model/LoginModel.php';
require_once 'model/RegisterModel.php';
require_once 'model/SubmissionModel.php';

require_once 'view/Feedback.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';
require_once 'view/LayoutView.php';
require_once 'view/SubmissionView.php';

require_once 'controller/AuthenticationController.php';
require_once 'controller/SubmissionController.php';
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
$submissionModel = new \Model\SubmissionModel($db);

$feedback = new \View\Feedback();
$sv = new \View\SubmissionView($submissionModel);
$loginView = new \View\LoginView($feedback, $sessionModel);
$registerView = new \View\RegisterView($feedback);
$layoutView = new \View\LayoutView($loginView, $registerView, $sv);

$auth = new \Controller\AuthenticationController($loginView, $loginModel, $sessionModel, $registerView, $registerModel);
$sc = new \Controller\SubmissionController($sv, $submissionModel, $sessionModel);

$c = new \Controller\MainController($sessionModel, $layoutView, $auth, $sc);

$c->render();

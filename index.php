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
$sm = new \Model\SessionModel();
$lm = new \Model\LoginModel($db, $sm);
$rm = new \Model\RegisterModel($db);
$subm = new \Model\SubmissionModel($db);

$feedback = new \View\Feedback();
$sv = new \View\SubmissionView($subm);
$lv = new \View\LoginView($feedback, $sm);
$rv = new \View\RegisterView($feedback);
$layout = new \View\LayoutView($lv, $rv, $sv);

$auth = new \Controller\AuthenticationController($lv, $lm, $sm, $rv, $rm);
$sc = new \Controller\SubmissionController($sv, $subm, $sm);

$c = new \Controller\MainController($sm, $layout, $auth, $sc);

$c->render();

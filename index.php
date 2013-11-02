<?php

require_once("view/LoginFormView.php");
require_once("view/DefaultPageView.php");
require_once("controller/AuthController.php");
require_once("controller/PageController.php");
require_once("controller/RegController.php");
require_once("common/Filter.php");


session_start();

$pageView = new \view\DefaultPageView();
$loginFormView = new \view\loginFormView();
$authController = new \controller\AuthController($loginFormView);
$regController = new \controller\RegController($loginFormView);

// Create user process
$regController->createUserIfRequested();

// Check if a logout is wanted, if so, do it
$authController->logoutUser();

// Gets an empty user-object, logged in user or from session 
$user = $authController->getUser();

// Authenticates and gets html for login-part depending on result
$authHtml = $authController->authenticateUser();
$authController->saveUser();

// If user is Online, start creating body
if($user->isAccepted()) {
	$pageController = new \controller\PageController($user, $pageView);
	$bodyHtml = $pageController->getHTML();
}
else
	$bodyHtml = $pageView->getOfflineHTML();


// Merge html
echo $pageView->getPage("PHP Project", $authHtml, $bodyHtml);
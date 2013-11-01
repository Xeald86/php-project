<?php

require_once("view/LoginFormView.php");
require_once("view/DefaultPageView.php");
require_once("controller/AuthController.php");
require_once("controller/PageController.php");
require_once("model/User.php"); //TODO: remove

session_start();

//Fejk session TODO: Remove
$fakeUser = new \model\User();
$fakeUser->setUserName("Xeald");
$fakeUser->setUserPass("pepsi123");
$fakeUser->setUserLevel(2);
$_SESSION["project::model::user"] = $fakeUser;


$pageView = new \view\DefaultPageView();
$loginFormView =  new \view\LoginFormView();
$authController = new \controller\AuthController($loginFormView);

/* Gets an empty user-object or from session */
$user = $authController->getUser();

//TODO: Här måste en hel del göras för inloggning av användare.

/* Authenticates and gets html for login-part depending on result */
$authHtml = $authController->authenticateUser();


// If user is Online, start creating body
if($user->isAccepted()) {
	$pageController = new \controller\PageController($user, $pageView);
	$bodyHtml = $pageController->getHTML();
}
else
	$bodyHtml = $pageView->getOfflineHTML();


/* merge html */
echo $pageView->getPage("PHP Project", $authHtml, $bodyHtml);
<?php

namespace controller;

require_once("view/StartView.php");
require_once("controller/QuizCreationController.php");

class PageController {
	
	/**
	 * @var User $user
	 * @var DefaultPageView $pageView
	 */
	private $user;
	private $pageView;
	
	 /**
	 * @param User $user
	 */
	public function __construct(\model\User $user, \view\DefaultPageView $pageView) {
		$this->user = $user;
		$this->pageView = $pageView;
	}
	
	/**
	 * @return String of location
	 */
	public function locateWhereWeAre() {
		return $this->pageView->getPageLocation();
	}
	
	/**
	 * @return String $html
	 * @var String $location [page to display]
	 * @var View $view [Selected view, dependign on the page-location]
	 */
	public function getHTML() {
		
		//Gets location to get correct html-body
		$location = $this->locateWhereWeAre();

		//TODO: Well the cases are plenty, is this the rigth way to go?
		switch ($location) {
		    case "start":
				$view = new \view\StartView($this->user);
				$html = $view->getHTML();
		        break;
			case "newquiz":
			case "addOption":
			case "addQuestion":
				$controller = new \controller\QuizCreationController($this->user);
				$controller->doNewQuiz();
				$html = $controller->getHTML();
		        break;
			default:
				$html = $this->pageView->somethingWentWrong();
				break;
		}
		
		return $html;
	}
	
}
	
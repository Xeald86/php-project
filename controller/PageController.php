<?php

namespace controller;

require_once("view/StartView.php");

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
		
		switch ($location) {
		    case "start":
				$view = new \view\StartView($this->user);
				$html = $view->getHTML();
		        break;
			default:
				$html = "Something went wrong. Please go to our <a href='index.php'>start page</a>";
				break;
		}
		
		return $html;
	}
	
}
	
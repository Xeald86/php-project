<?php

namespace controller;

class AuthController {
	
	/**
	 * @var \view\FormView $formView
	 * @var \model\User $user
	 */
	private $loginFormView;
	private $user;
	

	/**
	 * @param \view\LoginFormView $loginFormView
	 */
	public function __construct(\view\LoginFormView $loginFormView) {
		assert(isset($_SESSION));
		$this->loginFormView = $loginFormView;
	}
	
	/**
	 * @return User $user
	 */
	public function getUser() {
		if($this->loginFormView->sessionUserExist())
			$user = $this->loginFormView->getSessionedUser();
		else
			$user = $this->loginFormView->getEmptyUser();
		
		$this->user = $user;
		
		return $user;
	}
	
	/**
	 * @return string of HTML
	 */
	public function authenticateUser() {
		assert($this->user);
		if($this->user->isAccepted())
			$html = $this->loginFormView->getOnlineHTML($this->user);
		else
			$html = $this->loginFormView->getOfflineHTML();
		
		return $html;
	}
}

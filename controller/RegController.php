<?php

namespace controller;

require_once("model/RegModel.php");
require_once("model/UserData.php");

class RegController {
	
	/**
	 * @var \view\LoginFormView $loginFormView
	 */
	private $loginFormView;
	private $regModel;
	
	/**
	 * @param \view\LoginFormView $loginFormView
	 */
	public function __construct(\view\LoginFormView $loginFormView) {
		$this->loginFormView = $loginFormView;
		$this->regModel = new \model\RegModel();
	}

	public function createUserIfRequested() {
		if($this->loginFormView->userWantsToRegister()) {
			try {
				$userData = new \model\UserData(
					$this->loginFormView->getPostedUserName(),
					$this->loginFormView->getPostedUserPass(),
					$this->loginFormView->getPostedUserRePass()
				);

				if(!$userData->passIsSame())
					throw new \Exception("Passwords dosnt match");
				
				if($userData->passIsShort() or $userData->passIsLong() or
					$userData->userNameIsShort() or $userData->userNameIsLong())
						throw new \Exception("Passwords is invalid");
				
				if($this->loginFormView->userNameNeedSanitize())
					throw new \Exception("Username has unallowed signs");

				if($this->regModel->userExist($userData)) {
					$this->loginFormView->userDoesExist();
					throw new \Exception("Cant register user that already exist");
				}

				$this->regModel->doRegister($userData, $this->loginFormView);
			}
			catch(\Exception $e) {
				$this->loginFormView->registrationFailed();
			}
		}
	}
}
<?php

namespace model;

require_once("model/Service.php");

class RegModel {
	
	private $service;
	
	public function __construct() {
		$this->service = new \model\Service();
	}
	
	public function userExist(\model\UserData $userData) {
		return $this->service->userNameTaken($userData->getUserName());
	}
	
	/**
	 * @param UserData $userData
	 * @param LoginFormView $observer
	 */
	public function doRegister(\model\UserData $userData, $observer) {
		$this->service->addUser($userData);
		$observer->registrationComplete();
	}
}

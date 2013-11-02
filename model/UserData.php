<?php

namespace model;


class UserData {
	
	private $userName; 
	private $userPass; 
	private $userRePass;
	private $userLevel;
	
	/**
	 * @param UserName $userName
	 * @param Password $password
	 */
	public function __construct($userName, $userPass, $userRePass) {
		$this->userName = $userName;
		$this->userPass = $userPass;
		$this->userRePass = $userRePass;
		$this->userLevel = 1; //TODO: Ändra detta. Måste gå att välja
	}
	
	/**
	 * @return String of userName
	 */
	public function getUserName() {
		return $this->userName;
	}
	
	/**
	 * @return String of userPass
	 */
	public function getUserPass() {
		return $this->userPass;
	}
	
	/**
	 * @return Int of userLevel
	 */
	public function getUserLevel() {
		return $this->userLevel;
	}
	
	public function passIsSame() {
		if($this->userPass === $this->userRePass)
			return true;
		return false;
	}
	
	public function passIsShort() {
		if(strlen($this->userPass) < 5)
			return true;
		return false;
	}
	
	public function passIsLong() {
		if(strlen($this->userPass) > 20)
			return true;
		return false;
	}
	
	public function userNameIsShort() {
		if(strlen($this->userName) < 5)
			return true;
		return false;
	}
	
	public function userNameIsLong() {
		if(strlen($this->userName) > 20)
			return true;
		return false;
	}
}

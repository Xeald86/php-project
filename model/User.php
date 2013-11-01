<?php

namespace model;

class User {
	
	/**
	 * @var String $userName [Username of user]
	 * @var String $userPass [Password of user]
	 * @var Int $userLevel [level of authority (1=user, 2=administrator, 0=unregistered)]
	 */
	private $userName;
	private $userPass;
	private $userLevel = 0;

	/**
	 * @return string of userName
	 */
	public function getUserName() {
		return $this->userName;
	}
	
	/**
	 * @return Int of userLevel
	 */
	public function getUserLevel() {
		return $this->userLevel;
	}
	
	/**
	 * @return Boolean
	 */
	public function isAccepted(){
		return (isSet($this->userName) and isSet($this->userPass));
	}
	
	/**
	 * @param string $username
	 * TODO: No Securety At ALL!!!! ALSO USE TRY WHEN CALLING FOR THIS
	 */
	public function setUserName($username) {
		$this->userName = $username;
	}
	
	/**
	 * @param string $password
	 * TODO: No Securety At ALL!!!! ALSO USE TRY WHEN CALLING FOR THIS
	 */
	public function setUserPass($password) {
		$this->userPass = $password;
	}
	
	/**
	 * @param Int $level
	 * TODO: No Securety At ALL!!!! ALSO USE TRY WHEN CALLING FOR THIS
	 */
	public function setUserLevel($level) {
		$this->userLevel = $level;
	}
}

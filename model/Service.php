<?php

namespace model;

require_once("model/UserStorage.php");

use PDO;

class Service {
	
	private $pdo;
	
	public function __construct()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=php-project', 'root', '');
		$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 1);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$this->pdo = $pdo;
    }
	
	/**
	 * @return bool
	 * @var UserStorage $userStorage
	 * @param String $postedUser
	 * @param String $postedPass
	 */
	public function userExist($postedUser, $postedPass) {
		$userStorage = new \model\UserStorage($this->pdo);
		return $userStorage->userExist($postedUser, $postedPass);
	}
	
	/**
	 * @param String $userName
	 * @return Bool
	 */
	public function userNameTaken($userName) {
		$userStorage = new \model\UserStorage($this->pdo);
		return $userStorage->userNameTaken($userName);
	}
	
	/**
	 * @param UserData $userData
	 */
	public function addUser(\model\UserData $userData) {
		$userStorage = new \model\UserStorage($this->pdo);
		$userStorage->addUser($userData);
	}
	
	/**
	 * @param String $postedUser
	 * @param String $postedPass
	 * @return User
	 */
	public function getUser($postedUser, $postedPass) {
		$userStorage = new \model\UserStorage($this->pdo);
		return $userStorage->getUser($postedUser, $postedPass);
	}
}
	
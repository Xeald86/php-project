<?php

namespace model;

use PDO;

class UserStorage {
    /**
     * @var PDO $pdo
     */
    private $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
	
	/**
	 * @param String $postedUser
	 * @param String $postedPass
	 * @return bool
	 */
	public function userExist($postedUser, $postedPass) {
		$con = $this->pdo->prepare('SELECT id FROM users WHERE userName = "'.$postedUser.'" and userPass = "'. $postedPass .'"');
		$con->execute();
		$results = $con->fetchAll();
		
		return(count($results) == 1);
	}
	
	/**
	 * @param String $userName
	 * @return Bool
	 */
	public function userNameTaken($userName) {
		$con = $this->pdo->prepare('SELECT id FROM users WHERE userName = "'.$userName.'"');
		$con->execute();
		$results = $con->fetchAll();
		
		return (count($results) == 1);
	}
	
	/**
	 * @param UserData $userData
	 */
	public function addUser(\model\UserData $userData) {
			$con = $this->pdo->prepare('INSERT INTO users (userName, userPass, userLevel) VALUES ("'.$userData->getUserName() .'", "'.$userData->getUserPass() .'", "'.$userData->getUserLevel() .'")');
			$con->execute();
	}
	
	/**
	 * @param String $postedUser
	 * @param String $postedPass
	 * @return User $user
	 */
	public function getUser($postedUser, $postedPass) {
		$con = $this->pdo->prepare('SELECT userName, userPass, userLevel FROM users WHERE userName = "'.$postedUser.'" and userPass = "'. $postedPass .'"');
		$con->execute();
		$results = $con->fetchAll();
		
		if(count($results) == 1) {
			$user = new \model\User();
			$user->setUserName($results[0]->userName);
			$user->setUserPass($results[0]->userPass);
			$user->setUserlevel($results[0]->userLevel);
			
			return $user;
		}

		throw new Exception("Error Processing User-Request", 1);
	}
}
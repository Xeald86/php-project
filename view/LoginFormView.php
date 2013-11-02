<?php

namespace view;

require_once("model/User.php");
require_once("model/Service.php");

class LoginFormView {
	
	/**
	 * @var String $name [name on username input-field]
	 * @var String $pass [name on password input-field]
	 * @var String $subButton [name on submitButton]
	 * @var String $subButtonValue [value on submitButton]
	 * @var String $sessionUserLocation [session-location]
	 * @var String $loginMsg [form-messages]
	 */
	private static $name = "NameOfUser";
	private static $pass = "PassOfUser";
	private static $repass = "RePassOfUser";
	private static $subButton = "SubmitButton";
	private static $subButtonValue = "Login";
	private static $createButtonValue = "Create";
	private static $sessionUserLocation = "project::model::user";
	private $loginMsg;
	private $createMsg;
	
	
	/**
	 * @return string $html
	 * @param User $user
	 */
	public function getOnlineHTML(\model\User $user) {
		$html = "<span>You are online as <strong>". $user->getUserName() ."</strong></span>";
		$html .= " | <a href='?logout'>Settings</a> | <a href='?logout'>Log out</a>";

		return $html;
	}
	
	/**
	 * @return String $html
	 */
	public function getOfflineHTML() {
		$html = "<span>Please log in<span><br />";
		$html .= $this->getLoginForm();
		$html .= $this->getCreateForm();
		$html .= "<div class='clear'></div>";

		return $html;
	}
	
	/**
	 * [HTML of form]
	 * @return String of html
	 */
	public function getLoginForm(){
			$html = "<form action='?login' method='post'>
					<fieldset id='loginFieldset'>
						<legend>Use existing account</legend>";
			
			if(strlen($this->loginMsg) > 5)
				$html .= "<div id='loginMessage'>$this->loginMsg</div>";
						
			$html .= "	Username: <input type='text' value='' name='" . self::$name . "' /><br />
						Password: <input type='password' value='' name='" . self::$pass . "' />
						<input type='submit' name='" . self::$subButton . "' value='" . self::$subButtonValue . "' />
					</fieldset>
				</form>";
			
			return $html;
	}	
	
	/**
	 * [HTML of form]
	 * @return String of html
	 */
	public function getCreateForm(){
			$html = "<form action='?newUser' method='post'>
					<fieldset id='newUserFieldset'>
						<legend>Create a new account</legend>";
			
			if(strlen($this->createMsg) > 5)
				$html .= "<div id='newUserMessage'>$this->createMsg</div>";
			
			$html .= "Username: <input type='text' value='' name='" . self::$name . "' /><br />
						Password: <input type='password' value='' name='" . self::$pass . "' /><br />
						Retype: <input type='password' value='' name='" . self::$repass . "' />
						<input type='submit' name='" . self::$subButton . "' value='" . self::$createButtonValue . "' />
					</fieldset>
				</form>";
			
			return $html;
	}
	
	
	/**
	 * @return bool 
	 */
	public function sessionUserExist() {
		return isset($_SESSION[self::$sessionUserLocation]);
	}
	
	/**
	 * @return User $user 
	 */
	public function getSessionedUser() {
		return $_SESSION[self::$sessionUserLocation];
	}
	
	/**
	 * @return bool
	 */
	public function userWantsIn() {
		return ($_POST and $_SERVER['QUERY_STRING'] == "login" );
	}

	/**
	 * @return bool
	 */
	public function userWantsToRegister() {
		return ($_POST and $_SERVER['QUERY_STRING'] == "newUser" );
	}
	
	/**
	 * @return bool
	 */
	public function userWantsOut() {
		return ($_SERVER['QUERY_STRING'] == "logout" );
	}
	
	/**
	 * @return User $user
	 * @var String $postedUser
	 * @var String $postedPass
	 */
	public function getPostedUser() {
		
		// get the posted data
		$postedUser = $this->getPostedUserName();
		$postedPass = $this->getPostedUserPass();
		
		if($this->isPostedLoginDataOkey($postedUser, $postedPass)) {
			//Check if user exist with posted data
			if($this->userExist($postedUser, $postedPass)) {
				$user = $this->getUserFromStorage($postedUser, $postedPass); // The user exist, now get it
				return $user;
			}
			else
				$this->setLoginMsg('Incorrect Username or Password!');
		}			
		$user = new \model\User();
		return $user;
	}
	
	/**
	 * @param String $userName
	 * @param String $userPass
	 * @return bool
	 */
	public function isPostedLoginDataOkey($userName, $userPass) {
		if(strlen($userName) == 0)
			$this->setLoginMsg('Username is missing!');
		
		if(strlen($userPass) == 0)
			$this->setLoginMsg('Password is missing!');
		
		return (empty($this->loginMsg));
	}
	
	/**
	 * @param String $msg
	 */
	public function setLoginMsg($msg) {
		if(empty($this->loginMsg))
			$this->loginMsg = $msg;
		else
			$this->loginMsg .= '<br/>'.$msg;
	}
	
	/**
	 * @param String $msg
	 */
	public function setCreateMsg($msg) {
		if(empty($this->createMsg))
			$this->createMsg = $msg;
		else
			$this->createMsg .= '<br/>'.$msg;
	}
	
	/**
	 * @return String of userName
	 */
	public function getPostedUserName() {
		if (isset($_POST[self::$name]))
			return \common\Filter::sanitize($_POST[self::$name]);
		return "";
	}
	
	/**
	 * @return String of userPass
	 */
	public function getPostedUserPass() {
		if (isset($_POST[self::$pass]))
			return \common\Filter::sanitize($_POST[self::$pass]);
		return "";
	}
	
	/**
	 * @return String of userPass
	 */
	public function getPostedUserRePass() {
		if (isset($_POST[self::$repass]))
			return \common\Filter::sanitize($_POST[self::$repass]);
		return "";
	}
	
	/**
	 * @return User
	 * @param String $postedUser
	 * @param String $postedPass
	 * @var Service $service
	 */
	private function getUserFromStorage($postedUser, $postedPass) {
		$service = new \model\Service();
		return $service->getUser($postedUser, $postedPass);
	}
	
	/**
	 * @param String $postedUser
	 * @param String $postedPass
	 * @var Service $service
	 * @var Bool $exist
	 * @return Bool $exist
	 */
	public function userExist($postedUser, $postedPass) {
		$service = new \model\Service();
		return $service->userExist($postedUser, $postedPass);
	}
	
	/**
	 * @param User $user
	 */
	public function saveUserInSession(\model\User $user) {
		assert(isset($_SESSION));
		$_SESSION[self::$sessionUserLocation] = $user;
	}
	

	public function removeUserSession() {
		unset($_SESSION[self::$sessionUserLocation]);
	}
	
	public function userDoesExist() {
		$this->setCreateMsg('Username is already taken');
	}
	
	public function registrationComplete() {
		$this->setCreateMsg('<span>Du kan nu logga in</span>');
	}
	
	public function registrationFailed() {
		if (strlen($this->getPostedUserName()) < 5)
			$this->setCreateMsg('Username is to short (5-20 char)');

		if (strlen($this->getPostedUserPass()) < 5)
			$this->setCreateMsg('Password is to short (5-20 char)');
		
		if (strlen($this->getPostedUserName()) > 20)
			$this->setCreateMsg('Username is to long (5-20 char)');

		if (strlen($this->getPostedUserPass()) > 20)
			$this->setCreateMsg('Password is to long (5-20 char)');

		if (!($this->getPostedUserPass() === $this->getPostedUserRePass()))
			$this->setCreateMsg('Passwords dosnt match');

		if(isset($_POST[self::$name]))
			if ($this->stringNeedSanitize($_POST[self::$name]))
				$this->setCreateMsg('Username has unallowed characters');
	}
	
	public function userNameNeedSanitize() {
		return $this->stringNeedSanitize($_POST[self::$name]);
	}
	
	public function stringNeedSanitize($string) {
		return \common\Filter::needSanitize($string);
	}
}
	
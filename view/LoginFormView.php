<?php

namespace view;

require_once("model/User.php");

class LoginFormView {
	
	/**
	 * @var string $name [name on username input-field]
	 * @var string $pass [name on password input-field]
	 * @var string $subButton [name on submitButton]
	 * @var string $subButtonValue [value on submitButton]
	 * @var string $sessionUserLocation [session-location]
	 */
	private static $name = "NameOfUser";
	private static $pass = "PassOfUser";
	private static $subButton = "SubmitButton";
	private static $subButtonValue = "Login";
	private static $sessionUserLocation = "project::model::user";
	
	
	/**
	 * @return string $html
	 * @param User $user
	 * TODO: Se till så att Admin ersätts med användarnamnet.
	 */
	public function getOnlineHTML(\model\User $user) {
		$html = "<span>You are online as <strong>". $user->getUserName() ."</strong></span>";
		$html .= " | <a href='?logout'>Settings</a> | <a href='?logout'>Log out</a>";

		return $html;
	}
	
	/**
	 * @return string $html
	 * TODO: Finns massvis att göra här. Hela formuläret tex
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
	 * @return string of html
	 */
	public function getLoginForm(){
			return "<form action='?' method='post'>
					<fieldset id='loginFieldset'>
						<legend>Use existing account</legend>
						Username: <input type='text' value='' name='" . self::$name . "' /><br />
						Password: <input type='password' value='' name='" . self::$pass . "' />
						<input type='submit' name='" . self::$subButton . "' value='" . self::$subButtonValue . "' />
					</fieldset>
				</form>";
	}	
	
	/**
	 * [HTML of form]
	 * @return string of html
	 */
	public function getCreateForm(){
			return "<form action='?' method='post'>
					<fieldset id='createFieldset'>
						<legend>Create new account</legend>
						comming sooooon...
					</fieldset>
				</form>";
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
	 * @return User $user 
	 */
	public function getEmptyUser() {
		return new \model\User();
	}	
}
	
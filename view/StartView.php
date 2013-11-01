<?php

namespace view;

class StartView {
	
	/**
	 * @var User $user
	 */
	private $user;
	
	/**
	 * @param User $user
	 */
	public function __construct(\model\User $user) {
		$this->user = $user;
	}
	
	/**
	 * @return String $html
	 */
	 public function getHtml() {
	 	$html = "
	 		<h2>Welcome to the Quiz-project</h2>
	 		<p>
	 		The Quiz Project is created to help students and teachers,
	 		by creating a easy way to give and receive a Quiz in a choosen field.
	 		Continue by selecting any of the available options below.
	 		</p>
 		";
		
		if($this->user->getUserLevel() == 2)
			$html .= "
				<h3>Your options as a teacher</h3>
		 		<p>
		 		- <a href='?newquiz'>Create a new quiz</a><br />
		 		- <a href='?checkquizzes'>Check results of a quiz(3 available)</a><br />
		 		</p>
	 		";
		else
			$html .= "
			<h3>Your options as a student</h3>
	 		<p>
	 		- <a href='?takequizzes'>Take a given quiz (1 available)</a><br />
	 		- <a href='?inspectquizzes'>Inspect finished Quizzes (no finished quizzes)</a>
	 		</p>
 		";
		
		
		return $html;
	 }
}
	
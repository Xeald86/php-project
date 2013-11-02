<?php

namespace view;

class QuizCreationView {
	
	private $quiz;
	
	private static $sessionQuizLocation = "project::model::quiz";
	
	/**
	 * @return Bool
	 */
	public function isPosting() {
		return ($_POST);
	}
	
	/**
	 * @return Bool
	 */
	public function isWorkingOnQuiz() {
		return isSet($_SESSION[self::$sessionQuizLocation]);
	}
	
	/**
	 * @param: QuizModel $quiz
	 */
	public function saveQuizInSession(\model\QuizModel $quiz) {
		$_SESSION[self::$sessionQuizLocation] = $quiz;
	}
	
	public function loadQuizFromSession() {
		assert($_SESSION[self::$sessionQuizLocation]);
		return $_SESSION[self::$sessionQuizLocation];
	}
	
	/**
	 * @return String $html of HTML
	 * @var String $quizHTML of HTML
	 * @var String $html of HTML
	 * @param QuizModel $quiz
	 * @param String $addQuestionHTML
	 */
	public function getHTML(\model\QuizModel $quiz, $addQuestionHTML) {
		$this->quiz = $quiz;
		$quizHTML = $this->getQuizHTML();
		$html = $this->getBaseHTML($quizHTML, $addQuestionHTML);
		
		return $html;
	}
	
	/**
	 * @param String $quizHTML of HTML
	 * @param String $addQuestionHTML of HTML
	 * @return String of HTML
	 */
	private function getBaseHTML($quizHTML, $addQuestionHTML) {
		return "
			<h2>Creating a new Quiz</h2>
			<p>
				In this view, you can create a new quiz to send out to your students.
				You can add questions in the form to the right.
			</p>
			
			<div id='newQuizContainer'>$quizHTML</div>
			<div id='addQuestionContainer'>$addQuestionHTML</div>
			<div class='clear'></div>
		";
	}
	
	/**
	 * @return String $qHTML of HTML
	 * @var String $qHTML of HTML
	 */
	private function getQuizHTML() {
		$title = $this->quiz->getTitle();
		$head = $this->quiz->getHead();
		$questions = $this->quiz->getQuestions();
		
		$qHTML = "
			Title:<br />
			<input id='newQuizTitleInput' type='text' value='$title' /><br />
			Header-text:<br />
			<textarea id='newQuizHeadInput'>$head</textarea><br /><br />
		";
		
		$qHTML .= "Questions:<br />";
		if(Count($questions) == 0)
			$qHTML .= "<i>No Questions have yet to be added..</i>";

		foreach($questions as &$question) {
			$text = $question->getQuestionText();
			$options = $question->getQuestionOptions();
			$correct =$question->getQuestionCorrect();
			
			$qHTML .= "<div id='newQuizQuestionContainer'>Question: <strong>$text</strong><br />";
			
			foreach($options as &$option) {
				$qHTML .= "- $option";
				if(in_array($option, $correct))
					$qHTML .= " (Correct)<br />";
				else
					$qHTML .= " (False)<br />";
			}
			
			$qHTML .= "</div>";
		}
		
		return $qHTML;
	}
	
}
	
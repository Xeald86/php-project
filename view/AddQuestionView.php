<?php

namespace view;

class AddQuestionView {
	
	private static $sessionQuestionLocation = "project::model::question";
	private static $qText = "questionInput";
	private static $qOption = "optionInput";
	private static $qSubmit = "addQuestionSubmit";
	private static $qCorrect = "optionCorrect";
	private $question;
	private $errorMsg;
	
	/**
	 * @return String $html of HTML
	 * @var Int $a [Counter]
	 * @var Array $options
	 * @var String $questionText
	 */
	public function getFormHTML() {
		$options = $this->question->getQuestionOptions();
		$questionText = (isset($_POST[self::$qText]))
			? \common\Filter::sanitize($_POST[self::$qText]): "";
		
		$a = 0;
		
		$html = "
			<form action='?addQuestion' method='post'>
				Add Question<br />
				<span class='errorMsg'>$this->errorMsg</span>
				<hr>
				Question:<br />
				<input name='" .self::$qText. "' type='text' value='$questionText' /><br />
		";
		
		foreach($options as &$option) {
			$a++;
			$optionValue = (isset($_POST[self::$qOption ."".($a)]))
				? \common\Filter::sanitize($_POST[self::$qOption ."".($a)]): "";
			$html .= "
				Option $a:<br />
				<input name='" .self::$qOption. "$a' type='text' value='$optionValue' />
				<input type='checkbox' name='" .self::$qCorrect. "[]' value='" .($a-1). "'> correct<br />
			";
		}
		$html .= "
				<a href='?addOption' />+ add option</a><br />
				<br />
				<input type='submit' name='" .self::$qSubmit. "' value='Submit Question' />
			</form>
		";
		
		return $html;
	}
	
	/**
	 * @param QuestionModel $question
	 * @var Int $a [Counter]
	 * @var Array $options [All answers]
	 * @var Array $correct [Correct answers]
	 */
	public function saveQuestion($question) {
		assert($_POST);
		$a = 0;
		$options = $question->getQuestionOptions();
		$correct = $_POST[self::$qCorrect];
		
		$question->setText(\common\Filter::sanitize($_POST[self::$qText]));
		
		//TODO: Should this be done in QuestionModel?
		foreach($options as &$option) {
			$question->setOption(\common\Filter::sanitize($_POST[self::$qOption ."".($a+1)]), $a);
			if(in_array($a, $correct))
				$question->addCorrect(\common\Filter::sanitize($_POST[self::$qOption ."".($a+1)]));
			
			$a++;
		}
	}
	
	/**
	 * @param QuestionModel $question
	 * @var String $questionText
	 * @var Array $option Of QuestionModel
	 */
	public function validatePostedQuestion(\model\QuestionModel $question) {
		assert($_POST);
		$questionText = \common\Filter::sanitize($_POST[self::$qText]);
		
		if (\common\Filter::needSanitize($_POST[self::$qText]))
				$this->setErrorMsg('Question has unallowed characters');
		
		if(!isset($_POST[self::$qCorrect]))
			$this->setErrorMsg('There is no correct answer');
		
		if(strlen($questionText) == 0)
			$this->setErrorMsg('Question is empty');
		
		if(strlen($questionText) > 30)
			$this->setErrorMsg('Question is to long (max 30)');
		
		//Validating options
		for($a=0; Count($question->getQuestionOptions()) > $a; $a++) {
			$string = \common\Filter::sanitize($_POST[self::$qOption ."".($a+1)]);

			if(strlen($string) == 0)
				$this->setErrorMsg('Option '.($a+1).' is empty');

			if(strlen($string) > 30)
				$this->setErrorMsg('Option '.($a+1).' is to long (max 30)');
			
			if (\common\Filter::needSanitize($_POST[self::$qOption.''.($a+1)]))
				$this->setErrorMsg('Option '.($a+1).' has unallowed characters');
			
		}
	}
	
	/**
	 * @return Bool
	 */
	public function isPostedQuestionValid() {
		return (empty($this->errorMsg));
	}
	
	public function setErrorMsg($msg) {
		if(empty($this->errorMsg))
			$this->errorMsg = $msg;
		else
			$this->errorMsg .= "<br />$msg";
	}
	
	/**
	 * @return Bool
	 */
	public function userWantsToAddQuestion() {
		return ($_POST and $_SERVER['QUERY_STRING'] == "addQuestion");
	}
	
	/**
	 * @return Bool
	 */
	public function userWantsToAddOption() {
		return ($_SERVER['QUERY_STRING'] == "addOption");
	}
	
	/**
	 * @return Bool
	 */
	public function isWorkingOnQuestion() {
		return isSet($_SESSION[self::$sessionQuestionLocation]);
	}
	
	/**
	 * @return QuestionModel
	 */
	public function loadQuestionFromSession() {
		assert($_SESSION[self::$sessionQuestionLocation]);
		return $_SESSION[self::$sessionQuestionLocation];
	}
	
	/**
	 * @param: QuestionModel $question
	 */
	public function saveQuestionInSession(\model\QuestionModel $question) {
		$_SESSION[self::$sessionQuestionLocation] = $question;
	}
	
	public function fillQuestionForm(\model\QuestionModel $question) {
		$this->question = $question;
	}
}
	
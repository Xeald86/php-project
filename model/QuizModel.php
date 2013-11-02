<?php

namespace model;

class QuizModel {

	private $questions;
	private $title;
	private $head;
	
	public function __construct() {
		$this->questions = array();
	}
	
	/**
	 * @return String $title
	 */
	public function getTitle() {
		if(isset($this->title))
			return $this->title;
		return "";
	}
	
	/**
	 * return String $head
	 */
	public function getHead() {
		if(isset($this->head))
			return $this->head;
		return "";
	}
	
	/**
	 * return Array of QuestionModel
	 */
	public function getQuestions() {
		return $this->questions;
	}
	
	/**
	 * @param QuestionModel @question
	 * TODO: no securety, need to check so that question is valid, maby earlier, and filter out blank options, etc
	 */
	public function addQuestion(\model\QuestionModel $question) {
		array_push($this->questions, $question);
	}
}
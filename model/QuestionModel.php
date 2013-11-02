<?php

namespace model;

class QuestionModel {

	private $qText;
	private $qOptions;
	private $qCorrect; 
	
	/**
	 * @param String $text
	 * @param Array $options of Strings
	 * @param Array $correct of Strings
	 */
	public function __construct() {
		$this->qOptions = array("", "");
		$this->qCorrect = array();
	}
	
	/**
	 * @param String $text
	 * TODO: No securety here yet
	 */
	public function setText($text) {
		$this->qText = $text;
	}
	
	/**
	 * @param String $option
	 * @param Int $a [Counter]
	 */
	public function setOption($option, $a) {
		$this->qOptions[$a] = $option;
	}
	
	/**
	 * @param String $option
	 * TODO: No securety here yet
	 */
	public function addOption($option) {
		array_push($this->qOptions, $option);
	}
	
	public function addEmptyOption() {
		array_push($this->qOptions, "");
	}
	
	/**
	 * @param String $option
	 * TODO: No securety here yet
	 */
	public function addCorrect($option) {
		array_push($this->qCorrect, $option);
	}
	
	/**
	 * @return String
	 */
	public function getQuestionText() {
		if(isset($this->qText))
			return $this->qText;
		return "";
	}
	
	/**
	 * @return Array of Strings
	 */
	public function getQuestionOptions() {
		if(isset($this->qOptions))
			return $this->qOptions;
		return array();
	}
	
/**
	 * @return Array of Strings
	 */
	public function getQuestionCorrect() {
		if(isset($this->qCorrect))
			return $this->qCorrect;
		return array();
	}
	
}
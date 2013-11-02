<?php

namespace controller;

require_once("model/QuizModel.php");
require_once("model/QuestionModel.php");
require_once("model/QuizCreationModel.php");
require_once("view/QuizCreationView.php");
require_once("view/AddQuestionView.php");

class QuizCreationController {
	
	private $view;
	private $addQuestionView;
	private $user;
	private $quiz;
	private $model;
	private $question;
	
	public function __construct(\model\User $user) {
		$this->user = $user;
		$this->model = new \model\QuizCreationModel();
		$this->view = new \view\QuizCreationView();
		$this->addQuestionView = new \view\AddQuestionView();
	}
	
	public function doNewQuiz()  {
		
		//Check if saved quiz exist in session, if not, create an empty one. 
		$this->createNewOrLoadQuiz();
		
		//Check if a question is saved, if not, create an empty one
		$this->createNewOrLoadQuestion();
		
		//If Option is to be added to a question in work
		if($this->addQuestionView->userWantsToAddOption())
			$this->question->addEmptyOption();
		
		if($this->view->isPosting()) {
			if($this->addQuestionView->userWantsToAddQuestion()) {
				
				$this->addQuestionView->validatePostedQuestion($this->question);
				
				if($this->addQuestionView->isPostedQuestionValid()) {
					$this->addQuestionView->saveQuestion($this->question);
					$this->quiz->addQuestion($this->question);
					$this->createNewQuestion();
				}
			}
		}
		
		$this->saveQuizInSession();
		$this->saveQuestionInSession();
	}
	

	private function createNewOrLoadQuiz() {
		if($this->view->isWorkingOnQuiz()) {
			$this->quiz = $this->view->loadQuizFromSession(); // Loads saved quiz
		}
		else {
			$this->createNewQuizObject();
		}
	}
	
	private function createNewOrLoadQuestion() {
		if($this->addQuestionView->isWorkingOnQuestion()) {
			$this->question = $this->addQuestionView->loadQuestionFromSession(); // Loads saved question
		}
		else {
			$this->createNewQuestion();
		}
	}
	
	private function createNewQuizObject() {
		$this->quiz = new \model\QuizModel();
	}
	
	private function createNewQuestion() {
		$this->question = new \model\QuestionModel();
	}
	
	private function saveQuizInSession() {
		$this->view->saveQuizInSession($this->quiz);
	}
	
	private function saveQuestionInSession() {
		$this->addQuestionView->saveQuestionInSession($this->question);
	}
	
	/**
	 * @var String $addQuestionHTML of HTML
	 * @return String of HTML
	 */
	public function getHTML() {
		//Send question that form should generate from
		$this->addQuestionView->fillQuestionForm($this->question);
		
		//Generated formHTML
		$addQuestionHTML = $this->addQuestionView->getFormHTML();
		return $this->view->getHTML($this->quiz, $addQuestionHTML);
	}
	
}
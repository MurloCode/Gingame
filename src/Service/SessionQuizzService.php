<?php
namespace App\Service;

use App\Repository\PropositionRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionQuizzService
{
	private $session;
	private $proposition;

	public function __construct(RequestStack $requestStack, PropositionRepository $proposition) {
		$this->requestStack = $requestStack;
		$this->proposition = $proposition;
		$this->session = $this->requestStack->getSession();	
		$this->quizz = $this->requestStack->getCurrentRequest()->attributes->get('quizz');
		
	}

	/**
	 * Start session for Quizz
	 */
	public function start()  {

		// Get or Create session variable : Number of question and Score
		$this->questionNumber = 'question'.$this->quizz->getId();
		$question = $this->session->get($this->questionNumber, 0);

		$this->scoreQuizz = 'score'.$this->quizz->getId();;
		$score = $this->session->get($this->scoreQuizz, 0);

		$this->session->set($this->questionNumber, $question);
		$this->session->set($this->scoreQuizz, $score);
	}
	
	/**
	 * Add point after a good answer
	 */
	public function addPoint () {
		$this->session->set($this->scoreQuizz, $this->session->get($this->scoreQuizz) +1);
	}

	/**
	 * Increment Question number in Session variable
	 */
	public function nextQuestion () {
		$this->session->set($this->questionNumber, $this->session->get($this->questionNumber) +1);
	}

	/**
	 * Verify if the answer received are from the good question (Anti-Cheat !)... no bug too...
	 */
	public function noCheat() {
		// get POST
		$post = $this->requestStack->getCurrentRequest()->request->get('options');
		// Get Question ID from Proposition ID
		$questionFromPropositionId = $this->proposition->find($post)->getQuestion()->getId();
		// Get Question ID from Session
		$questionFromSession = $this->quizz->getQuestions()[$this->session->get($this->questionNumber)]->getId() ;

		return ($questionFromPropositionId === $questionFromSession ? true : false);
	}

	/**
	 * Return Session Question Number
	 */
	public function getQuestionNumber () {
		return $this->session->get($this->questionNumber);
		// return $this->session->get('question140');
	}

	/**
	 * Return Session Score Quizz
	 */
	public function scoreQuizz () {
		return $this->session->get($this->scoreQuizz);
	}

	/**
	 * Return True if the Quizz is ended
	 */
	public function endQuizz () {
		return ($this->quizz->countQuestions() === $this->session->get($this->questionNumber) +1 ? true : false);
	}

	/**
	 * Remove Session of this Quizz
	 */
	public function remove () {
		$this->session->remove($this->questionNumber);
		$this->session->remove($this->scoreQuizz);
	}
	

}
<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quizz;
use App\Form\AnswerType;
use App\Form\PropositionType;
use App\Repository\PropositionRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
* @Route("/quizz", name="quizz_")
*/
class QuizzController extends AbstractController
{
	/**
	 * @Route("/list", name="list")
	 */
	public function index(QuizzRepository $quizzRepository): Response
	{      
		
		return $this->render('quizz/list.html.twig', [
			'quizz' => $quizzRepository->findAll() ,
		]);
	}

	 /**
	 * @Route("/{id}", name="show", requirements={"id"="\d+"})
	 *
	 * @return Response
	 */
	public function show(Quizz $quizz, RequestStack $requestStack, PropositionRepository $proposition)
	{
		$this->requestStack = $requestStack;
		$session = $this->requestStack->getSession();

		// Vérify if Session Exist
		$sessionName = 'questionID'.$quizz->getId() ;
		$questionSession = $session->get($sessionName);
	
		$sessionPoint = 'questionPoint'.$quizz->getId() ;
		$quizzPoint = $session->get($sessionPoint);

		$questions = $quizz->getQuestions();
		
		// Verify if Quiz is started or ended
		if ($questionSession === null) {
			$session->set($sessionName, 0);
			$session->set($sessionPoint, 0);
			
		} elseif (count($questions) <= $session->get($sessionName) +1 ) {
			return $this->redirectToRoute('quizz_result', ['question' => $questions[$session->get($sessionPoint)] ]);
		}

		// Verify if form is Sent
		if (isset($_POST["options"])) {

			// Verify if answer is valid
			$reponse = $proposition->find($_POST["options"]);

			// Verify if the answer are from the good question (Anti-Cheat !)
			if ($questions[$questionSession]->getId() !== $reponse->getQuestion()->getId()) {
				return $this->render('quizz/show.html.twig', [
					'quizz' => $quizz,
					'question' => $questions[$session->get($sessionName)],
				]);
			}

			// Increment Question in Session variable
			$session->set($sessionName, $questionSession+1);

			if ($reponse->getIsValid() == true) {
				$session->set($sessionPoint, $quizzPoint +1);
				dump("Points : " . $session->get($sessionPoint));
			} else {
				dump('lose');
			}
		}		

		return $this->render('quizz/show.html.twig', [
			'quizz' => $quizz,
			'question' => $questions[$session->get($sessionName)],
		]);
	
		
		
	}


	/**
	 * @Route("/result", name="result")
	 */
	public function result(){

		return $this->render('quizz/win.html.twig',[

		]);
	}
}

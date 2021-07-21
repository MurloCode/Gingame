<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quizz;
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
	public function show(Quizz $quizz, RequestStack $requestStack)
	{
		$this->requestStack = $requestStack;
		$session = $this->requestStack->getSession();
		
		// Vérify if Session Exist
		$sessionName = 'questionID'.$quizz->getId() ;
		$questionSession = $session->get($sessionName);
		
		$questions = $quizz->getQuestions();
		
		// Verify if Quiz is ended
		// dd(array_keys($session->get('questionID'), $quizz->getId()));
		//dd($questionSession);

			if ($questionSession === null) {
				$session->set($sessionName, 0);
				//dd($session->get('questionID'));
			} elseif (count($questions) <= $session->get($sessionName) +1 ) {
				dd("FINI !");
			} else {
				$session->set($sessionName, $questionSession+1);
			}

			return $this->render('quizz/show.html.twig', [
				'quizz' => $quizz,
				'question' => $questions[$session->get($sessionName)]
			]);
	
		
		
	}

	
}

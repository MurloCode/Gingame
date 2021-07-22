<?php

namespace App\Controller;

use App\Entity\Historic;
use App\Entity\Question;
use App\Entity\Quizz;
use App\Form\AnswerType;
use App\Form\PropositionType;
use App\Form\QuizzType;
use App\Repository\PropositionRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizzRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
		$sessionName = 'questionID'.$quizz->getId();
		$questionSession = $session->get($sessionName);
	
		$sessionPoint = 'questionPoint'.$quizz->getId() ;
		$quizzPoint = $session->get($sessionPoint);

		$questions = $quizz->getQuestions();
		
		// Verify if Quiz is started or ended
		if ($questionSession === null) {
			$session->set($sessionName, 0);
			$session->set($sessionPoint, 0);
			
		} elseif (count($questions) <= $session->get($sessionName) +1 ) {
			return $this->redirectToRoute('quizz_result', ['id' => $quizz->getId() ]);
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
	 * @Route("/{id}/result", name="result")
	 */
	public function result(Quizz $quizz, RequestStack $requestStack){

		$this->requestStack = $requestStack;
		$session = $this->requestStack->getSession();

		// Verify if quizz is finish
		// if not : redirect to quizz
		$sessionName = 'questionID'.$quizz->getId();
		
		if ($session->get($sessionName) +1 !== count($quizz->getQuestions())) {
			return $this->redirectToRoute('quizz_show', ['id' => $quizz->getId() ]);
		}

		// Add Score, User and Quizz in Historic entity
		$historic = new Historic;
		$historic->setUser($this->getUser());
		$historic->setQuizz($quizz);
		$historic->setScore($session->get('questionPoint'.$quizz->getId()));
		$historic->setOutOf(count($quizz->getQuestions()));

		$em = $this->getDoctrine()->getManager();
		$em->persist($historic);

		// If user is connected : save into BDD and delete session's quizz
		if ($this->getUser() !== null) {
			$em->flush();

			$session->remove('questionID'.$quizz->getId());
			$session->remove('questionPoint'.$quizz->getId());

		}

		return $this->render('quizz/result.html.twig',[
			'result' => $historic 
		]);

	}


	 /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        $quizz = new Quizz();
        $form = $this->createForm(QuizzType::class, $quizz);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
           
			$data = $request->request->all();
			$em = $this->getDoctrine()->getManager();

			$quizz->setCreatedBy($this->getUser());
			$quizz->setDescription($data['quizz']['description']);
            $em->persist($quizz);
			
			

			dump($data);
			//$question = $data['quizz']['questions'];

			$question = new Question;
			$question->setQuestion($data['quizz']['questions']);
			$question->setCreatedBy($this->getUser());
			$question->addQuizz($quizz);
			
			$em->persist($question);

			//dd($question);

            $em->flush();

            $this->addFlash('success', 'votre quizz a bien été ajouté');
            return $this->redirectToRoute('home');
        }

        return $this->render('quizz/add.html.twig', [
            
            'form' => $form->createView()
        ]);
    }
}

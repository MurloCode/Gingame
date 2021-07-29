<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Form\RandomQuizzType;
use App\Repository\QuestionRepository;
use App\Repository\QuizzRepository;
use App\Repository\ThemeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/random", name="random_")
 */
class RandomQuizzController extends AbstractController
{

	/**
	 * @Route("/", name="generate")
	 */
	public function genereate(QuestionRepository $questionRepository, UserRepository $users, ThemeRepository $themes, Request $request): Response
	{

		$quizz = new Quizz();

		// Generate Questions
		$questionRepository->setMaxResult(10);
		$questions = $questionRepository->randomQuestion();

		// Set "Oquizz" of Creator
		$user = $users->findOneBy(['login' => 'Oquizz']);
		$quizz->setCreatedBy($user);

		// Set "Random" Theme
		$theme = $themes->findOneBy(['name' => 'Random']);
		$quizz->addTheme($theme);

		// Add all questions in Quizz
		foreach($questions as $question) {
			$quizz->addQuestion($question);
		}

		$quizz->setName('Random');

		$em = $this->getDoctrine()->getManager();
		$em->persist($quizz);
		$em->flush();

		// Set New Name to Random Quizz
		$quizzId = $quizz->getId();
		$quizz->setName('Random Quizz N°' . $quizzId);
		$em->persist($quizz);
		$em->flush();

		return($this->redirectToRoute('quizz_show', ['id' => $quizzId]));

	}
	
}

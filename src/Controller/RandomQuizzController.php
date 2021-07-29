<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Repository\QuestionRepository;
use App\Repository\QuizzRepository;
use App\Repository\ThemeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/random/quizz", name="random_")
 */
class RandomQuizzController extends AbstractController
{
    /**
     * @Route("/", name="quizz")
     */
    public function index(): Response
    {
        return $this->render('random_quizz/index.html.twig', [
            'controller_name' => 'RandomQuizzController',
        ]);
    }

    /**
     * @Route("/generate", name="generate")
     */
    public function genereate(QuestionRepository $questionRepository, UserRepository $users, ThemeRepository $themes): Response
    {

        $quizz = new Quizz;

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

        return $this->render('random_quizz/index.html.twig', [
            'controller_name' => 'RandomQuizzController',
        ]);
    }
    
}

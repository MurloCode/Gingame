<?php

namespace App\Controller;

use App\Repository\QuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizzController extends AbstractController
{
    /**
     * @Route("/quizz", name="quizz")
     */
    public function index(QuizzRepository $quizzRepository): Response
    {

        
        return $this->render('quizz/index.html.twig', [
            'quizzs' => $quizzRepository->findAll() ,
        ]);
    }
}

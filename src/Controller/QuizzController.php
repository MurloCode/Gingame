<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quizz;
use App\Repository\QuestionRepository;
use App\Repository\QuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->render('quizz/index.html.twig', [
            'quizzs' => $quizzRepository->findAll() ,
        ]);
    }

     /**
     * @Route("/{id}", name="show", requirements={"id"="\d+"})
     *
     * @return Response
     */
    public function show(Quizz $quizz)
    {
        
        
        return $this->render('quizz/show.html.twig', [
            'quizz' => $quizz,
            
           
        ]);
    }

    
}

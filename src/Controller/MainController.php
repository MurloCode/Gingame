<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use App\Repository\HistoricRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizzRepository;
use App\Repository\ThemeRepository;
use App\Repository\UserRepository;
use App\Service\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(MessageGenerator $messageGenerator, QuizzRepository $quizzRepository, ThemeRepository $themeRepository, HistoricRepository $historicRepository, UserRepository $userRepository, QuestionRepository $questionRepository): Response
    {
        $this->addFlash('', $messageGenerator->randomMessage());

        $mostPopular = $historicRepository->findMostPopular(4);

        // Get most played Quizz
        foreach ($mostPopular as $key) {
            foreach($key as $value) {
                $popularQuizz[] = $quizzRepository->findById($value)[0];
            }
        }

        // Get most active User
        $getUsersPlay = $historicRepository->findMostActivePlayer();  
        foreach ($getUsersPlay as $key => $value) {
            $userPlay[$key][0] = $userRepository->findById($value['id'])[0];
            $userPlay[$key][1] = $value['count'];
        }

        // Get most creative User
        $getUsersActive = $quizzRepository->findMostCreativeUsers();
        foreach ($getUsersActive as $key => $value) {
            $userCreate[$key][0] = $userRepository->findById($value['id'])[0];
            $userCreate[$key][1] = $value['count'];
            $userCreate[$key][2] = $questionRepository->findMostQuestionUsers($value['id'])['count'];
            // $userCreate[$key][2] = findMostQuestionUsers
         
        }
     
    


        $lastquizz = $quizzRepository->findLastQuizz(4);

        $themeChild = $themeRepository->findChildThemes(8);

        $lastTheme = $themeRepository->findLastThemeChild(4);


    //    dd('coucou');

        return $this->render('main/index.html.twig', [
            'lastquizz' => $lastquizz,
            'themechild' => $themeChild,
            'lasttheme' => $lastTheme,
            'popularQuizz' => $popularQuizz,
            'userPlay' => $userPlay,
            'userCreate' => $userCreate
        ]);
    }

    /**
     * @Route("/qui-sommes-nous", name="team")
     */
    public function team(): Response
    {
        return $this->render('main/team.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

     /**
     * @Route("/contacts", name="contact")
     */
    public function contact(Request $request, ContactNotification $contactNotification): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $contactNotification->notify($contact);
            $this->addFlash('success', 'votre email a bien été envoyé');
            return $this->redirectToRoute('home');
        }

        return $this->render('main/contact.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/mentions-legales", name="notice")
     */
    public function notice(): Response
    {
        return $this->render('main/notice.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

}

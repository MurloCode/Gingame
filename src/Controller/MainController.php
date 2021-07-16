<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
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
    public function contact(): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        return $this->render('main/contact.html.twig', [
            'controller_name' => 'MainController',
            'formView' => $form->createView()
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

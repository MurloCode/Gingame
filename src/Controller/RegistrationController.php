<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password.
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $user->setActivationToken(md5(uniqid()));

            $user->setRoles(['ROLE_USER']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

        //     $email = (new Email())
        // ->from('corentin@gmail.com')
        // ->to($user->getEmail())
        // //->cc('cc@example.com')
        // //->bcc('bcc@example.com')
        // //->replyTo('fabien@example.com')
        // //->priority(Email::PRIORITY_HIGH)
        // ->subject('Time for Symfony Mailer!')
        // ->text('Sending emails is fun again!')
        // ->html(
        //     $this->renderView(
        //         'email/activation.html.twig', ['token' => $user->getActivationToken()]
        //     ),
        //     'text/html'
        // );
        // $mailer->send($email);


            // Après création du compte, on redirige vers la page de login
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registerForm' => $form->createView(),
        ]);
    }

    /**
 * @Route("/activation/{token}", name="activation")
 */
public function activation($token, UserRepository $users)
{
    // On recherche si un utilisateur avec ce token existe dans la base de données
    $user = $users->findOneBy(['activation_token' => $token]);

    // Si aucun utilisateur n'est associé à ce token
    if(!$user){
        // On renvoie une erreur 404
        throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
    }

    // On supprime le token
    $user->setActivationToken(null);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($user);
    $entityManager->flush();

    // On génère un message
    $this->addFlash('message', 'Utilisateur activé avec succès');

    // On retourne à l'accueil
    return $this->redirectToRoute('home');
}
}

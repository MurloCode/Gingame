<?php

namespace App\Controller;

use App\Entity\Historic;
use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\HistoricRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
	/**
	 * @Route("/", name="user_index", methods={"GET"})
	 */
	public function index(UserRepository $userRepository): Response
	{
		return $this->render('user/index.html.twig', [
			'users' => $userRepository->findAll(),
		]);
	}

	/**
	 * @Route("/new", name="user_new", methods={"GET","POST"})
	 */
	public function new(Request $request): Response
	{
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();

			return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('user/new.html.twig', [
			'user' => $user,
			'form' => $form,
		]);
	}

	/**
	 * @Route("/{id}", name="user_profil", methods={"GET"})
	 */
	public function show(User $user, HistoricRepository $historic): Response
	{   
		$historidisplay = $historic->findAll();
		
		return $this->render('user/show.html.twig', [
			'user' => $user,
			'historic' => $historidisplay
			
			
		]);
	}

	/**
	 * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, User $user, SluggerInterface $slugger): Response
	{

		
		$this->denyAccessUnlessGranted('USER_EDIT', $user, 'Petit malin');

		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())  {
		 
			// /** @var UploadedFile $brochureFile */
			// $imageFile = $form->get('image')->getData();

			// if ($form->get('imageFile')->getData()) {
				
			// 	$user->setImageFile($form->get('imageFile')->getData());
			// }
		 
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('user_profil', ['id' => $user->getId()]);
		}
		

		return $this->renderForm('user/edit.html.twig', [
			'user' => $user,
			'form' => $form,
		]);
	}

	/**
	 * @Route("/{id}", name="user_delete", methods={"POST"})
	 */
	public function delete(Request $request, User $user): Response
	{
		if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($user);
			$entityManager->flush();
		}

		return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
	}

	 /**
     * @Route("/{id}/follow", name="user_follow")
     */
    public function follow(User $user, Request $request)
    {
        $this->getUser()->follow($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($this->getUser());
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/{id}/unfollow", name="user_unfollow")
     */
    public function unfollow(User $user, Request $request)
    {
        $this->getUser()->unfollow($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($this->getUser());
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

   

}

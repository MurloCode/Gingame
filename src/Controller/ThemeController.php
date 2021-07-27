<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Repository\QuizzRepository;
use App\Repository\ThemeRepository;
use App\Service\MessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/theme", name="theme_")
 */
class ThemeController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
	public function index(ThemeRepository $themeRepository): Response
	{
		// Call Theme without "parent" : "root Themes"
		$rootThemes = $themeRepository->findRootThemes();
	
		// Send root Theme to template
		return $this->render('theme/index.html.twig', [
			'rootThemes' => $rootThemes,
		]);
	}

    /**
     * @Route("/{id}", name="show", requirements={"id"="\d+"})
     */
	public function show(Theme $theme=null, MessageGenerator $messageGenerator): Response
	{
// We want to display a 404 if the quizz doesn't exist.
		// We order a quizz by its id
		// If quizz existes we can play 
		//else we receive a 404
		if ($theme === null) {
			$this->addFlash('', $messageGenerator->randomErrorMessage());
			return $this->render('errors/error404.html.twig');
		}
		// Send Child Theme to template
		return $this->render('theme/show.html.twig', [
			'theme' => $theme
		]);
		
		

	}

		/**
	 * @Route("/list", name="list")
	 */
	public function themeIndex(ThemeRepository $themeRepository): Response
	{      
		$themeParent = $themeRepository->findRootThemes();
		
		return $this->render('quizz/themelistindex.html.twig', [
			'themes' => $themeRepository->findAll(),
			'themeparent' => $themeParent
		]);
	}
	

	/**
	 * @Route("/list/{id}", name="list_id")
	 */
	public function themeList(Theme $themes,ThemeRepository $themeRepository, QuizzRepository $quizz, $id): Response
	{      	

		$themeChild = $themeRepository->findChildThemes();

		return $this->render('quizz/themelist.html.twig', [
			'themes' => $themes,
			'quizz' => $quizz->find($id),
			'themechild' => $themeChild,
		]);
	}

}





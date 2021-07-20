<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Repository\QuizzRepository;
use App\Repository\ThemeRepository;
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
     * @Route("/{id}", name="show")
     */
	public function show(Theme $theme, QuizzRepository $quizzRepository): Response
	{
		// Call Theme without "parent" : "root Themes"
		//$theme = new Theme;
	
		//dd($theme->getName());
		$quizz = $quizzRepository->findAll();
		//dd($quizz);
		// Send root Theme to template
		return $this->render('theme/show.html.twig', [
			'theme' => $theme,
			'quizz' => $quizz
		]);
	}

}





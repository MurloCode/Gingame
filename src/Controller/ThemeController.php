<?php

namespace App\Controller;

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
     * @Route("/", name="list")
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

	

}





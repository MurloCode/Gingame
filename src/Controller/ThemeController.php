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


		// $rootTheme = $themeRepository->findBy(['themeParent' => 'Serie TV']);
		$rootTheme = $themeRepository->findAll();
		dd($rootTheme);

		return $this->render('theme/index.html.twig', [
			'themes' => $themeRepository->findAll(),
		]);
	}
}

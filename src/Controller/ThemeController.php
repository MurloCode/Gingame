<?php

namespace App\Controller;

use App\Repository\ThemeRepository;
use PhpParser\Node\Name;
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
 
		$root = $themeRepository->findRootThemes();
		dd($root);

		$themes = $themeRepository->findAll();

		foreach($themes as $theme) {

			$parents = $theme->getThemeParent();
			//dump(count($names));
			foreach ( $parents as $parent) {
				dump($theme . " est enfant de " . $parent->getName());
				//dump(count($name));
			}
			
		}

		dd('END');


		return $this->render('theme/index.html.twig', [
			'themes' => $themes,
		]);
	}
}

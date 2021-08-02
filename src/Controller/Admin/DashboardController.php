<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Entity\Quizz;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
	/**
	 * @Route("/admin", name="admin")
	 */
	public function index(): Response
	{
		//$routeBuilder = $this->get(CrudUrlGenerator::class)->build();
		//$url = $routeBuilder->setController(QuizzCrudController::class)->generateUrl();
		// $url = $routeBuilder->setController(QuizzCrudController::class)->generateUrl();
		// $url = $routeBuilder->setController(QuestionCrudController::class)->generateUrl();
		// return $this->redirect($url);
		return $this->render('admin/dashboard/index.html.twig');
	}

	public function configureDashboard(): Dashboard
	{
		return Dashboard::new()
			// ->renderSidebarMinimized(false)
			->setTitle('Oquizz')
		;
	}

	public function configureMenuItems(): iterable
	{
		yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
		//yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
		yield MenuItem::section('Blog');
		yield MenuItem::linkToCrud('Quizz', 'fas fa-map-marker-alt', Quizz::class);
		yield MenuItem::linkToCrud('Question', 'fas fa-map-marker-alt', Question::class);
		yield MenuItem::linkToCrud('User', 'fas fa-map-marker-alt', User::class);
		yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'home');
		
	}

	public function configureAssets(): Assets
	{
		return Assets::new()
			->addCssFile('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css')
			->addCssFile('css/admin/admin.css');
	}

	// public function configureCrud(): Crud
	// {
	// 	return Crud::new()
	// 		->overrideTemplate('crud/quizz', 'admin/quizz/quizz.html.twig')

	// 	;
	// }

}

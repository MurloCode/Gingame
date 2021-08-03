<?php

namespace App\Controller\Admin;

use App\Entity\Quizz;
use App\Form\PropositionType;
use App\Form\QuestionType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuizzCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Quizz::class;
	}

	
	public function configureFields(string $pageName): iterable
	{
		return  [
			'name',
			'description',
			CollectionField::new('new_questions')
				//->setCssClass("myClass")
				//->setProperty('Property_Question')
				->setFormtypeOption("mapped",false)
				->setEntryIsComplex(true)
				->allowAdd()
				->allowDelete()
				->setEntryType(QuestionType::class)
				->hideOnIndex(),
			
			AssociationField::new('themes'),
				//AssociationField::new('questions'),
		];
		
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setDefaultSort(['id' => 'DESC'])
			->addFormTheme('admin/dashboard/index.html.twig');
	}

}

<?php

namespace App\Controller\Admin;

use App\Entity\Quizz;
use App\Form\PropositionType;
use App\Form\QuestionType;
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
		$newQuestion = 
			CollectionField::new('new_questions')
				->setFormtypeOption("mapped",false)
				->setEntryType(QuestionType::class)
				->allowAdd()
				->allowDelete()
				//->setEntryType(PropositionType::class)
				//->setEntryIsComplex(true)
		;

		$newQuestion2 = 
			CollectionField::new('new_questions')
				->setFormtypeOption("mapped",false)
				->allowAdd()
				->allowDelete()
				->setEntryType(CollectionType::class)
				//->setEntryType(PropositionType::class)
				->setEntryIsComplex(true)
		;

		// $newQuestion = 
		// 	ArrayField::new('new_questions')
		// 		-->setFormType(CollectionType::class)
		// ;

		$newProposition = 
			CollectionField::new('new_propositions')
				->setFormtypeOption("mapped",false)
				->allowAdd()
				->allowDelete()
				->setEntryType(PropositionType::class)
				->setEntryIsComplex(true)
		;

		$fields =  [
			'name',
			'description',
			$newQuestion,
			AssociationField::new('questions'),
			AssociationField::new('themes'),
		
		];
	   /* $monsuperparamdurl = true;
		if($monsuperparamdurl){
			$fields[] = AssociationField::new('questions');
		}*/
		
		return $fields;
	}
	
}

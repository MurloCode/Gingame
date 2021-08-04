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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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

		// $question = new CollectionField('questions');
		// $question->setLabel('Questions');

		// $question->add('question')
		// ->add('propositions', CollectionType::class, [
		// 	'entry_type' => PropositionType::class,
		// 	'allow_add' => true,
		// 	'allow_delete' => true,
		// 	'prototype_name' => 'props',
		// 	'block_name' => 'propositions',
		// ])


		return  [
			TextField::new('name')
				->setLabel('Nom de votre Quizz'),
			TextareaField::new('description')
				->setLabel('Description de votre Quizz'),
			AssociationField::new('themes'),
			CollectionField::new('new_questions')
				->setLabel('Vos questions')
				->setCssClass('quizzCSS')
				->setFormtypeOption("mapped",false)
				->setEntryType(QuestionType::class)
				// ->setEntryIsComplex(true)
				// ->allowAdd()
				// ->allowDelete()
				->hideOnIndex(),
			
				//AssociationField::new('questions'),

		];
		
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setDefaultSort(['id' => 'DESC'])
			//->overrideTemplate('crud/form_theme.html.twig', 'admin/form_theme.html.twig')
			->setFormThemes(['admin/form_theme.html.twig', '@EasyAdmin/crud/form_theme.html.twig'])

		;
	}

}

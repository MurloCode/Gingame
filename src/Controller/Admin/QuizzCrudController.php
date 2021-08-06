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
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @isGranted("ROLE_ADMIN")
 */
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

			FormField::addPanel('Quizz')
				->setCssClass('container'),

				IdField::new('id')
					->onlyOnIndex(),

				TextField::new('name')
					->setLabel('Nom de votre Quizz')
					->setCssClass('titleField col-12'),

				IntegerField::new('played', 'Joué')
					->OnlyOnIndex(),

				TextareaField::new('description')
					->setLabel('Description')
					->setCssClass('descField col-8'),

				TextField::new('imageFile')
					->setFormType(VichImageType::class)
					->setCssClass('imgField col-4')
					->hideOnIndex(),
				
				ImageField::new('image')
					->setBasePath($this->getParameter('quizz_images'))
					->setCssClass('col-4')
					->onlyOnIndex(),

				AssociationField::new('themes')
					->setCssClass('themeField col-12')
					->hideOnIndex(),
					

			FormField::addPanel('Questions')
				->addCssClass('container'),				

				CollectionField::new('new_questions')
					->setLabel('Vos questions')
					->setCssClass('quizzCSS')
					->setFormtypeOption("mapped",false)
					->setEntryType(QuestionType::class)
					// ->setEntryIsComplex(true)
					// ->allowAdd()
					// ->allowDelete()
					->hideOnIndex(),

			AssociationField::new('questions'),

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

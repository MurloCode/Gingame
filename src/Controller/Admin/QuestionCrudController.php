<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Form\PropositionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @isGranted("ROLE_ADMIN")
 */
class QuestionCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Question::class;
	}

	
	public function configureFields(string $pageName): iterable
	{
		return [
			IdField::new('id')
				->onlyOnIndex(),

			'question',

			// AssociationField::new('propositions'),
			CollectionField::new('propositions')
				->setLabel('Propositions')
				->setCssClass('quizzCSS')
				->setFormtypeOption("mapped",false)
				->setEntryType(PropositionType::class)
				// ->setEntryIsComplex(true)
				// ->allowAdd()
				// ->allowDelete()
				->hideOnIndex(),
				
			AssociationField::new('quizzs'),
		];
	}
	
}

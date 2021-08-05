<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @isGranted("ROLE_ADMIN")
 */
class UserCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return User::class;
	}

	
	public function configureFields(string $pageName): iterable
	{
	   return [
			'login',
			'email',
			AssociationField::new('quizz')->onlyOnIndex(),
			// 'publishedAt',
			AssociationField::new('friends'),
			DateField::new('createdAt')
				->setLabel("Date d'inscription")
				->setFormat('dd-MM-Y'),
		];
	}
}

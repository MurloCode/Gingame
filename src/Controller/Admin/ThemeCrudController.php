<?php

namespace App\Controller\Admin;

use App\Entity\Theme;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ThemeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Theme::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Thème')
                ->setCssClass('container'),

            TextField::new('name')
                ->setLabel('Nom du Thème')
                ->setCssClass('titleField col-12'),

            TextareaField::new('description')
                ->setLabel('Description')
                ->setCssClass('descField col-8'),

            TextField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->setCssClass('imgField col-4')
                ->hideOnIndex(),

            ImageField::new('image')
                ->setBasePath($this->getParameter('theme_images'))
                ->setCssClass('col-4')
                ->onlyOnIndex(),

            AssociationField::new('themeParent')
                ->setCssClass('themeField col-12')
                ->hideOnIndex(),
        ];
    }
    

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setDefaultSort(['name' => 'DESC'])
		;
	}


}

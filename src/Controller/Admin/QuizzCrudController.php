<?php

namespace App\Controller\Admin;

use App\Entity\Quizz;
use App\Form\QuestionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuizzCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quizz::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
          $fields =  [
        'id',
        'name',
        'description',
        CollectionField::new('new_questions')->setFormtypeOption("mapped",false)
            ->allowAdd()
            ->allowDelete()
            ->setEntryType(QuestionType::class)
            ->setEntryIsComplex(true),
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

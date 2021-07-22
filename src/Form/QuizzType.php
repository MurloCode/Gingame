<?php

namespace App\Form;

use App\Entity\Proposition;
use App\Entity\Question;
use App\Entity\Quizz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\PropositionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class QuizzType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('name', null, [
                'help' => 'Un quizz 100% Babar'
            ])
            ->add('description', null, [
                'help' => 'Connais tu vraiment bien Babar'
            ])
            ->add('questions', TextType::class, [
                'help' => 'Qui est Babar ?',
                'mapped' => false
                ])
            ->add('themes', null, [
                'multiple' => true,
                'expanded' => true,
            ])
            
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;
       
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quizz::class,
        ]);
    }
}

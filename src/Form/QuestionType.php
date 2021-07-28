<?php

namespace App\Form;

use App\Entity\Proposition;
use App\Entity\Question;
use Doctrine\ORM\Query\Lexer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			// ->add('question')
			// ->add('right_text')
			// ->add('right_elem')
			// ->add('wrong_text')
			// ->add('wrong_elem')
			// ->add('quizzs')
			// ->add('themes')
			// ->add('propositions', TextType::class, [
			// 	'help' => 'Un éléphant',
			// 	'mapped' => false
			// ])
			//->add('createdBy')

			// ->add('proposition1', TextType::class, [
			// 	'label' => 'Proposition 1',
			// 	'mapped' => false
			// ])
			// ->add('proposition2', TextType::class, [
			// 	'label' => 'Proposition 2',
			// 	'mapped' => false
			// ])
			// ->add('proposition3', TextType::class, [
			// 	'label' => 'Proposition 3',
			// 	'mapped' => false
			// ])
			// ->add('proposition1', TextType::class, [
			// 	'label' => 'Proposition 4',
			// 	'mapped' => false
			// ])


			->add('question')
			->add('propositions', CollectionType::class, [
				'mapped' => false,
				'entry_type' => PropositionType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'prototype' => true,
			])
			
			
			
			// ->add(
			// 	$builder->create('FORMULAIRE', FormType::class, [
			// 		'by_reference' => false,
			// 	])
			// 		// ->add('question', CollectionType::class, [
			// 		// 		'entry_type' => TextType::class,
			// 		// 	])
			// 		->add('proposition', CollectionType::class, [
			// 				'mapped' => false,
			// 				'entry_type' => PropositionType::class,
			// 				'allow_add' => true,
			// 				'allow_delete' => true,
			// 				'prototype' => true,
			// 		])
			// )



			// ->add('propositions', EntityType::class, [
			// 	'class' => Proposition::class,
			// 	'allow_extra_fields' => true,
			// ])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Question::class,
		]);
	}
}

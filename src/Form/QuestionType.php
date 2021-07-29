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
				->add('question')
			// ->add('right_text')
			// ->add('right_elem')
			// ->add('wrong_text')
			// ->add('wrong_elem')
			// ->add('quizzs')
			// ->add('themes')
			->add('propositions', CollectionType::class, [
				'entry_type' => PropositionType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'prototype_name' => 'props',
			])
			
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Question::class,
		]);
	}
}

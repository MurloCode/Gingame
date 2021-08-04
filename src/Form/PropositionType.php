<?php

namespace App\Form;

use App\Entity\Proposition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropositionType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('text', TextType::class, [

				'label' => 'Proposition',
				'attr' => [
					// 'class' => '[props]'.'Field' <-- A étudier
					'class' => 'testCSS',
					'class' => 'answerField',
				],
				// 'class' => '[props]'.'Field' <-- A étudier
			])
			// ->add('text', TextType::class, [
			// 	'label' => 'Proposition',

			// ])
			->add('is_valid', CheckboxType::class, [
				'label' => 'Bonne réponse',
				'attr' => [
					'class' => 'isValid'
				]
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Proposition::class,
			'attr' => [
				'class' => 'eaPropositionCSS',
			],
		]);
	}

	
}

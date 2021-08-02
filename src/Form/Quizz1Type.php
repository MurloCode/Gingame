<?php

namespace App\Form;

use App\Entity\Quizz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Quizz1Type extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name')
			->add('description')
			->add('new_questions', CollectionType::class, [
				"mapped" => false,
				"entry_type" => QuestionType::class,
				"allow_add" => true,
				"allow_delete" => true,
				
			])
			->add('themes')
			->add('createdBy')
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Quizz::class,
		]);
	}
}

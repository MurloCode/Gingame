<?php

namespace App\Form;

use App\Entity\Proposition;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('question')

			->add()

			->add('proposition[0]', TextType::class, [
				'mapped' => false,
			])
			->add('proposition[1]', TextType::class, [
				'mapped' => false,
			])
			->add('proposition[2]', TextType::class, [
				'mapped' => false,
			])
			->add('proposition[3]', TextType::class, [
				'mapped' => false,
			])

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
			// ->add('propositions', CollectionType::class, [
			// 	'mapped' => false,
			// 	'entry_type' => PropositionType::class,
			// 	'allow_add' => true,
			// 	'allow_delete' => true
			// ])
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

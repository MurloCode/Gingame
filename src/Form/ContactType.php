<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', TextType::class,[
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple: Attends']
        ])
        ->add('lastname', TextType::class,[
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple: Charles']
        ])
        ->add('pseudo', TextType::class,[
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple: Oquizzinator']
        ])
        ->add('email', TextType::class,[
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple: Oquizz@mail.com']
        ])
        ->add('message', TextType::class,[
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple: Bonjour, dans Scrubs le scooter de JD se nomme sasha et non Sarah Connor sur la question n°...']
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
<?php

namespace App\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // register user's email
        ->add('email', EmailType::class, [
            'label' => 'Adresse Email:',
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple: Oquizz@mail.com']
        ])
        // register user's login
        ->add('login', null, [
            'label' => 'Pseudo:',
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple: Oquizzinator']
        ])
        // ->add('roles', ChoiceType::class, [
        //     'choices' => [
        //         'Utilisateur' => 'ROLE_USER'
        //     ],
        // ])
       // plain password to record the registration
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Le mot de passe doit être le même',
            'options' => ['attr' => ['autocomplete' => 'new-password', 'class' => 'form-control', 'placeholder' => 'Exemple: 0Qu1zz@123'],],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confirmation du mot de passe'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un mot de passe',
                ]),
        // 6 characters min to validate the password        
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit avoir au moins {{ limit }} caracteres',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ]);

        // Use captcha to securise registration
        $builder->add('captcha', CaptchaType::class,[
            'invalid_message' => 'Les caractères doivent être identiques.',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

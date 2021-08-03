<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login')
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('Created_At')
            ->add('friends')
            ->add('image', FileType::class, [
                'label' => 'Charger une nouvelle image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                    ])
                ],
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                // Avant construction du formulaire, on va d'abord vérifier dans
                // quel contexte on se trouve :
                // - Création : on rendra obligatoire la saisie d'un mot de passe
                // - Edition : la saisie du mot de passe sera facultative
                $form = $event->getForm();
                $userData = $event->getData();

                if ($userData->getId() === null) {
                    // Mode création
                    // Le mot de passe sera obligatoire
                    $required = true;
                    // $form->add('password', PasswordType::class, [
                    //     'mapped' => false,
                    //     'required' => $required
                    // ]);
                } else {
                    // Mode édition
                    // Le mot de passe ne pas sera obligatoire
                    $required = false;
                
                }

                // On ajoute dynamiquement le champ Password
                // Qui est obligatoire en création
                // et optionnel en édition
                $form->add('password', PasswordType::class, [
                    'mapped' => false,
                    'required' => $required
                ]);
               
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

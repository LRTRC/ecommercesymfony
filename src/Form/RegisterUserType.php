<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'attr' => ['placeholder' => 'Indiquez votre adresse email']
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 30
                    ])
                ],
                'first_options' =>
                ['label' => 'Votre mot de passe',
                    'attr' => ['placeholder' => 'Mot de passe'],
                    'hash_property_path' => 'password'],
                'second_options' =>
                ['label' => 'Confirmer le mot de passe',
                    'attr' => ['placeholder' => 'Confirmez le mot de passe'
                    ]
                ],
                'mapped' => false,
                'label' => 'Confirmer votre mot de passe'
            ])
            ->add(
                'firstname',
                TextType::class,
                ['label' => 'Prénom',
                    'attr' =>
                    ['placeholder' => 'Indiquez votre prénom']]
            )
            ->add(
                'lastname',
                TextType::class,
                ['label' => 'Nom',
                    'attr' =>
                    ['placeholder' => 'Indiquez votre nom']]
            )
            ->add(
                'submit',
                SubmitType::class,
                ['label' => 'Valider',
                    'attr' =>
                    ['class' => 'btn-success'
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'constraints' => [
                new UniqueEntity([
                    'entityClass' => User::class,
                    'fields' => 'email'
                ])
            ]
        ]);
    }
}

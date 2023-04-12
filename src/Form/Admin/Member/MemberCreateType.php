<?php

namespace App\Form\Admin\Member;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => 'col-lg-4 col-form-label required fw-semibold fs-6'
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg form-control-solid mb-3 mb-lg-0',
                    'autocomplete' => 'new-email',
                ]
            ])
            ->add('gender', ChoiceType::class, [
                'required' => true,
                'label' => 'Civilité',
                'label_attr' => [
                    'class' => 'col-lg-4 col-form-label required fw-semibold fs-6'
                ],
                'choices' => User::GENDERS,
                'attr' => [
                    'class' => 'form-select form-select-lg form-select-solid mb-3 mb-lg-0',
                    'data-control' => 'select2'
                ]
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'col-lg-4 col-form-label required fw-semibold fs-6'
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg form-control-solid mb-3 mb-lg-0',
                ]
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'col-lg-4 col-form-label required fw-semibold fs-6'
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg form-control-solid mb-3 mb-lg-0',
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'form-control form-control-lg form-control-solid',
                    ],
                    'help' => 'Laissez vide pour ne pas modifier votre mot de passe',
                    'help_attr' => [
                        'class' => 'my-2 fst-italic text-mute'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer',
                    'attr' => [
                        'class' => 'form-control form-control-lg form-control-solid',
                    ],
                    'help' => 'Laissez vide pour ne pas modifier votre mot de passe',
                    'help_attr' => [
                        'class' => 'my-2 fst-italic text-mute'
                    ]
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

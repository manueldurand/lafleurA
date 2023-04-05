<?php

namespace App\Form\Admin\Profile;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
//                'type' => PasswordType::class,
//                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'required' => true,
//                'first_options'  => [
//                    'label' => 'Mot de passe',
//                    'class' => 'col-lg-4 col-form-label required fw-semibold fs-6'
//                ],
//                'second_options' => [
//                    'label' => 'Confirmer',
//                    'class' => 'col-lg-4 col-form-label required fw-semibold fs-6'
//                ],
                'label' => 'Mot de passe',
                'attr' => [
                    'class' => 'form-control form-control-lg form-control-solid',
                    'autocomplete' => false,
                ],
                'help' => 'Laissez vide pour ne pas modifier votre mot de passe',
                'help_attr' => [
                    'class' => 'my-2 fst-italic text-mute'
                ]
//                'options' => [
//                    'attr' => [
//                        'class' => 'col-lg-4 col-form-label required fw-semibold fs-6'
//                    ]
//                ],
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

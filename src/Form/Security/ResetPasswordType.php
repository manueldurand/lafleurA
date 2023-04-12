<?php

namespace App\Form\Security;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                "plainPassword",
                RepeatedType::class,
                [
                    "type"           => PasswordType::class,
                    "required"       => true,
                    "invalid_message" => "Les deux mots de passe doivent être identiques.",
                    "options"        => [
                        "attr" => [
                            "class"        => "form-control bg-transparent",
                            "autocomplete" => "off",
                            "required"     => true,
                        ],
                    ],
                    "first_options"  => [
                        "label"      => "Mot de passe",
                        "label_attr" => [
                            "placeholder" => "Mot de passe",
                            "class" => "form-control bg-transparent",
                        ],
                    ],
                    "second_options" => [
                        "label"      => "Confirmer le mot de passe",
                        "label_attr" => [
                            "class" => "form-control bg-transparent",
                        ],
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'        => User::class,
            'validation_groups' => ['CreatePlainPassword'],
        ]);
    }
}

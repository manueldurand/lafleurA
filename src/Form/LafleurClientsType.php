<?php

namespace App\Form;

use App\Entity\LafleurClients;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LafleurClientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomClient')
            ->add('prenomClient')
            ->add('emailClient')
            ->add('motDePasse')
            ->add('telephone')
            ->add('lafleurAdresses')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LafleurClients::class,
        ]);
    }
}

<?php

namespace App\Form\Admin\Profile;

use App\Entity\User;
use App\Form\Admin\Files\UserAvatarType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', UserAvatarType::class,[
                'required' => true,
                'label' => 'Avatar',
                "constraints" => [
                    new Valid(),
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

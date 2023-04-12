<?php

namespace App\Form\Admin\Files;

use App\Entity\Image;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image as ImageConstraint;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserAvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'userImageFile',
                VichImageType::class,
                [
                    'required'   => true,
                    'label'      => false,
                    'help'       => 'Ce fichier doit obligatoirement être au format JPG, JPEG.<br>L\'image doit respecter les dimensions suivantes : 300px X 300px.',
                    'help_html'  => true,
                    'constraints' => [
                        new ImageConstraint([
                            'minWidth' => '300',
                            'maxWidth' => '300',
                            'minHeight' => '300',
                            'maxHeight' => '300',
                            'maxSizeMessage' => 'L\'image doit respecter les dimensions suivantes : 300px X 300px.',
                            'mimeTypes' => [
                                'image/jpeg'
                            ],
                            'mimeTypesMessage' => 'Veuillez joindre un fichier au format JPG, JPEG.',
                        ])
                    ],
                    // VichUploader config
                    'allow_delete'    => false,
                    'download_uri'    => false,
                    'image_uri'       => false,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Credit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CreditAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // do the same for the rest

            ->add('c_cin', FileType::class, [
                'label'=> 'Photo CIN',
                'required'   => true,
                'attr' => array('accept' => 'image/jpeg,image/png, application/pdf, application/x-pdf, text/plain, text/html',
                    'placeholder' => 'Choose file' ),
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg,', 'image/jpeg', 'image/png', 'image/gif', 'image/jpg',
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Le fichier n\'est pas valide, assurez vous d\'avoir un fichier au format PDF, PNG, JPG, JPEG)',
                    ]),
                ]
            ])
            ->add('Attestation_Travail', FileType::class, [
                'label'=> 'Attestation de Travail',
                'required'   => true,
                'attr' => array('accept' => 'image/jpeg,image/png, application/pdf, application/x-pdf, text/plain, text/html',
                    'placeholder' => 'Choose file' ),
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg,', 'image/jpeg', 'image/png', 'image/gif', 'image/jpg',
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Le fichier n\'est pas valide, assurez vous d\'avoir un fichier au format PDF, PNG, JPG, JPEG)',
                    ]),
                ]
            ])
            ->add('Attestation_Salaire', FileType::class, [
                'label'=> 'Attestation de salaire',
                'attr' => array('accept' => 'image/jpeg,image/png, application/pdf, application/x-pdf, text/plain, text/html',
                    'placeholder' => 'Choose file' ),
                'required'   => true,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg,', 'image/jpeg', 'image/png', 'image/gif', 'image/jpg',
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Le fichier n\'est pas valide, assurez vous d\'avoir un fichier au format PDF, PNG, JPG, JPEG)',
                    ]),
                ]
            ])
            ->add('Document_Credit', FileType::class, [
                'label'=> 'Document Credit',
                'attr' => array('accept' => 'image/jpeg,image/png, application/pdf, application/x-pdf, text/plain, text/html',
                    'placeholder' => 'Choose file' ),
                'required'   => true,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg,', 'image/jpeg', 'image/png', 'image/gif', 'image/jpg',
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Le fichier n\'est pas valide, assurez vous d\'avoir un fichier au format PDF, PNG, JPG, JPEG)',
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credit::class,
            'mapped' => false,
        ]);
    }
}

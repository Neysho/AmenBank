<?php

namespace App\Form;

use App\Entity\Credit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Status', ChoiceType::class, [
                'choices'  => [
                    'Accordé' => 'Accordé',
                    'Non Accordé' => 'Non Accordé'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credit::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\User;
use App\Entity\Virement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VirementAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Montant', MoneyType::class, [
                'attr' => [
                    'class' => 'custom_class'
                ]
            ])
            ->add('Motif', TextareaType::class, [
                'attr' => [
                    'class' => 'custom_class'
                ]
            ])
            ->add('Date_Execution',DateType::class, array(
                'label' =>'Date Execution',
                'format' => 'yyyy-MM-dd',
            ))
            ->add('Account',EntityType::class,
                array('class' =>Account::class,'choice_label' =>'number'))

            ->add('Account_2',EntityType::class,
                array('class' =>Account::class,'choice_label' =>'number'))

            ->add('Devise', ChoiceType::class, [
                'choices'  => [
                    'TND' => 'TND',
                    'USD' => 'USD',
                    'EUR' => 'EUR',
                    'CAD' => 'CAD',
                    'AED' => 'AED',
                    'JPY' => 'JPY',
                    'CHF' => 'CHF'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Virement::class,
        ]);
    }
}

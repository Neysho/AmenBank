<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('libelle', TextareaType::class, [
                'attr' => [
                    'class' => 'custom_class'
                ]
            ])
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
            ->add('solde', MoneyType::class, [
                'attr' => [
                    'class' => 'custom_class'
                ]
            ])
//            ->add('date_solde',DateType::class, array(
//                'label' =>'Date Solde',
//                'format' => 'yyyy-MM-dd',
//            ))

            ->add('User', EntityType::class,
                array('class' =>User::class,'choice_label' =>'username'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Operation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('symbol')
            ->add('position')
            ->add('type')
            ->add('lots')
            ->add('openTime')
            ->add('openPrice')
            ->add('closeTime')
            ->add('closePrice')
            ->add('profit')
            ->add('netProfit')
            ->add('transmitter')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}

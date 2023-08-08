<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AccountTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(

                'mapped' => false

            ))
            ->add('password', RepeatedType::class, array(

                'type' => PasswordType::class,

                'invalid_message' => 'Les deux mots de passe doivent être identiques',

                'options' => array(

                    'attr' => array(

                        'class' => 'password-field'

                    )

                ),

                'required' => true,

            ))
            ->add('submit', SubmitType::class, array(

                'attr' => array(

                    'class' => 'btn btn-primary btn-block'

                )

            ));
    }
}

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

                'mapped' => false,
                'label' => 'Ancien mot de passe',

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
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répétez votre mot de passe'],

            ))
            ->add('submit', SubmitType::class, array(

                'attr' => array(

                    'class' => 'btn btn-primary btn-block'

                ),
                'label' => 'Modifier',

            ));
    }
}

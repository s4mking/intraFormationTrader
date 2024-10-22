<?php

namespace App\Form;

use App\Entity\User;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
            'label_attr' => ['class' => 'sr-only palceholder', 'for'=>"email"],
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email'
                ],
                ])
            ->add('nom', TextType::class, [
                'label_attr' => ['class' => 'sr-only palceholder', 'for'=>"nom"],
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom'
                ],
            ])
            ->add('prenom', TextType::class, [
                'label_attr' => ['class' => 'sr-only palceholder', 'for'=>"prenom"],
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom'
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => false,
                'attr' => ['autocomplete' => 'new-password',
                    'placeholder' => 'Mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
                 ->add('captcha', CaptchaType::class, [
        'label' => false,
        'attr' => [
            'placeholder' => 'Saisissez le captcha',
            'class' => 'captcha-input mt-3 mb-3',
        ],
        'reload' => true,
        'as_url' => true,
        'invalid_message' => 'Captcha invalide, essayez encore.',
    ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

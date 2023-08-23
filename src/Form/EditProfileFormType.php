<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ]) ->add('adresse', TextType::class, [
                'label_attr' => ['class' => 'sr-only palceholder', 'for'=>"adresse"],
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse'
                ],
            ]) ->add('telephone', TextType::class, [
                'label_attr' => ['class' => 'sr-only palceholder', 'for'=>"telephone"],
                'label' => false,
                'attr' => [
                    'placeholder' => 'Téléphone'
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Modifier'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

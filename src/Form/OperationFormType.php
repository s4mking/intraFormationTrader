<?php
namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class OperationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ...
            ->add('credit', NumberType::class, [
                'label' => False,
                'required' => false,
            ])
            ->add('retrait', NumberType::class, [
                'label' => False,
                'required' => false,
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => User::class,
                'choice_label' => function(User $user){
                    return $user->getFullName();
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Effectuer la transaction'])
            // ...
        ;
    }
}

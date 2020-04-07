<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,[
                'required' =>false,
            ])
            ->add('password', PasswordType::class,[
                'required' => false,
            ])
            ->add('category', ChoiceType::class,[
                'required' =>false,
                'choices'  => [
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_MAINTENANCE' => 'ROLE_MAINTENANCE',
                    'ROLE_COMMERCIAL' => 'ROLE_COMMERCIAL',
                    ]
            ])
            ->add('mail', TextType::class,[
                'required' =>false,
            ])
            ->add('confirm_password', PasswordType::class,[
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class,[
                'required' =>false,
            ])
            ->add('serialNumber')
            ->add('description')
            ->add('name')
            ->add('materialState', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'neuf' => 'neuf',
                    'bon' => 'bon',
                    'moyen' => 'moyen',
                    'usagé' => 'usagé',
                ]
            ])
            ->add('type', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'défibrillateur' => 'défibrillateur',
                    'fauteuil' => 'fauteuil',
                    'lit' => 'lit',
                ]
            ])
            ->add('availability', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'oui' => 'oui',
                    'non' => 'non',
                ]
            ])
            ->add('options', ChoiceType::class,[
                'required' =>false,
                'choices'  => [
                    'electrique' => 'electrique',
                    'manuel' => 'manuel',
                    'ultra leger' => 'ultra leger',
                    'enfant' => 'enfant',
                    'confort' => 'confort',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}

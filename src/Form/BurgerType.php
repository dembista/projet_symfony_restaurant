<?php

namespace App\Form;

use App\Entity\Burger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BurgerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomBurger', TextType::class, [
            'label' => 'Nom Burger',
            'label_attr'=> [
                'class'=>'form-label mt-4'
            ],
            'attr' => [
                'class' => 'nomBurger',
            ]
        ])
        ->add('prix', NumberType::class, [
            'label' => 'Prix Burger',
            'label_attr'=> [
                'class'=>'form-label mt-4'
            ],
            'attr' => [
                'class' => 'prix',
            ]
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description Burger',
            'label_attr'=> [
                'class'=>'form-label mt-4'
            ],
            'attr' => [
                'class' => 'nomBurger',
            ]
        ])
        ->add('images', FileType::class, [
            'label' => false,
            'multiple'=> true,
            'mapped' => false,
            'attr' => [
                'class' => 'ig',
            ]
        ])
        ->add('submit', SubmitType::class, [
            'attr'=>[
                'class'=>'btn add'
            ],
            'label'=>'Ajouter'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Burger::class,
        ]);
    }
}

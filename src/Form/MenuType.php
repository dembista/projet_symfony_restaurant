<?php

namespace App\Form;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Complement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomMenu', TextType::class, [
            'label' => 'Nom Menu',
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
        ->add('burger', EntityType::class,[
            'class'=>  Burger::class,
            'choice_label'=>'nom_burger',
            'attr'=> [
                'class'=> 'form-control w-100'
            ],
            'label'=> 'Burger',
            'label_attr'=> [
                'class'=>'form-label mt-4 '
            ]
        ]) 
        ->add('complement', EntityType::class,[
            'class'=>  Complement::class,
            'choice_label'=>'nom_complement',
            'attr'=> [
                'class'=> 'form-control w-100'
            ],
            'label'=> 'Complement',
            'label_attr'=> [
                'class'=>'form-label mt-4 '
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
        ->add('type', TextType::class, [
            'label' => 'Nom Menu',
            'label_attr'=> [
                'class'=>'form-label mt-4'
            ],
            'attr' => [
                'class' => 'nomBurger',
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
            'data_class' => Menu::class,
        ]);
    }
}

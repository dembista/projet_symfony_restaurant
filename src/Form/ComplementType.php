<?php

namespace App\Form;

use App\Entity\Complement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ComplementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_complement', TextType::class, [
                'label' => 'Nom Complement',
                'label_attr'=> [
                    'class'=>'form-label mt-4'
                ],
                'attr' => [
                    'class' => 'nomBurger',
                ]
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix Complement',
                'label_attr'=> [
                    'class'=>'form-label mt-4'
                ],
                'attr' => [
                    'class' => 'prix',
                ]
            ])
            ->add('images', FileType::class, [
                'label' => false,
                'multiple'=> true,
                'mapped' => false,
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
            'data_class' => Complement::class,
        ]);
    }
}

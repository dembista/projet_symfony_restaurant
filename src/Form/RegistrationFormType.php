<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'label_attr'=> [
                    'class'=>'form-label mt-4'
                ],
                'attr' => [
                    'class' => 'nomBurger',
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom',
                'label_attr'=> [
                    'class'=>'form-label mt-4'
                ],
                'attr' => [
                    'class' => 'nomBurger',
                ]
            ])
            ->add('telephone', NumberType::class, [
                'label' => 'Telephone',
                'label_attr'=> [
                    'class'=>'form-label mt-4'
                ],
                'attr' => [
                    'class' => 'nomBurger',
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'label_attr'=> [
                    'class'=>'form-label mt-4'
                ],
                'attr' => [
                    'class' => 'nomBurger',
                ]
            ])
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                'class' => 'nomBurger'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '180',
            ],
            'label' => 'Adresse email',
            'label_attr' => [
                'class' => 'form-label  mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email(),
                new Assert\Length(['min' => 2, 'max' => 180])
            ]
        ])

        ->add('isRecruteur', ChoiceType::class, [
            'choices'  => [
                'Choix' => null,
                'Recruteur' => true,
                'Candidat' => false,
            ],
            'attr' => [
                'class' => 'dropdown-toggle',
               
            ],
            'label' => 'type utilsateur',
            'label_attr' => [
                'class' => 'form-label  m-4'
            ],
            'constraints' => [
                new Assert\NotNull(),
            
            ]
        ])
        

        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ]
            ],
            'second_options' => [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Confirmation du mot de passe',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ]
            ],
            'invalid_message' => 'Les mots de passe ne correspondent pas.',
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'min' => 8,
                    'max' => 200,
                    'minMessage' =>
                        'Your password must be at least {{ limit }} characters long.',
                    'maxMessage' =>
                        'Your password cannot be longer than {{ limit }} characters.',
                ]),
                new Assert\NotCompromisedPassword([
                    'message' => 'Mot de passe trop simple',
                ]),
            
            ],
        ])
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4'
            ],
            'label' =>'Valider'
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

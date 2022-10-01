<?php

namespace App\Form;

use App\Entity\Recruteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ConsultantRecruteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('NameEntreprise', TextType::class,[
            'attr' =>[
                'class' =>'form-control',
                'minlength' =>'2',
                'maxlength' => '50'
            ],
            'required'=> false,
            'label' => 'Nom de l\'entreprise',
            'label_attr' =>[
                'class'=> 'form-label mt-4'
            ],
            'constraints' =>[
                new Assert\Length(['min' => 2, 'max' => 50]),
                new Assert\NotBlank()
            ]
        ])
            ->add('active', CheckboxType::class,[
                'attr' =>[
                    'class' =>'form-check-input',
                ],
                'required'=> false,
                'label' => 'activationPartenaire',
                'label_attr' =>[
                    'class'=> 'form-check-label '
                ],
                'constraints' =>[
                    new Assert\NotNull(),
                   
                ]
            ])
            ->add('adresseEntreprise', TextareaType::class, [
                'attr' =>[
                    'class' =>'form-control',
                    'min' => 1,
                    'max' => 5
                ],
                'label' => 'Adresse  de l\'entreprise',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' =>[
                 new Assert\NotBlank(),
               
                ]
            ])
            ->add('submit',SubmitType::class, [
                'attr'=>[
                    'class' => 'btn btn-primary m-5'
                ],
                'label' =>'Valider'
               ]) ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recruteur::class,
        ]);
    }
}

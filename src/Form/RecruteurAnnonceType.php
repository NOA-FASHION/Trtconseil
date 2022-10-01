<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecruteurAnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class,[
            'attr' =>[
                'class' =>'form-control',
                'minlength' =>'2',
                'maxlength' => '50'
            ],
            'required'=> false,
            'label' => 'Annonce',
            'label_attr' =>[
                'class'=> 'form-label mt-4'
            ],
            'constraints' =>[
                new Assert\Length(['min' => 2, 'max' => 50]),
                new Assert\NotBlank()
            ]
        ])

        ->add('intitulePoste', TextType::class,[
            'attr' =>[
                'class' =>'form-control',
                'minlength' =>'2',
                'maxlength' => '50'
            ],
            'required'=> false,
            'label' => 'intitulé du Poste',
            'label_attr' =>[
                'class'=> 'form-label mt-4'
            ],
            'constraints' =>[
                new Assert\Length(['min' => 2, 'max' => 50]),
                new Assert\NotBlank()
            ]
        ])

        ->add('lieuTravail', TextType::class,[
            'attr' =>[
                'class' =>'form-control',
                'minlength' =>'2',
                'maxlength' => '50'
            ],
            'required'=> false,
            'label' => 'Lieu de travail',
            'label_attr' =>[
                'class'=> 'form-label mt-4'
            ],
            'constraints' =>[
                new Assert\Length(['min' => 2, 'max' => 50]),
                new Assert\NotBlank()
            ]
        ])

        ->add('horairePost', TextType::class,[
            'attr' =>[
                'class' =>'form-control',
                'minlength' =>'2',
                'maxlength' => '50'
            ],
            'required'=> false,
            'label' => 'Horaire',
            'label_attr' =>[
                'class'=> 'form-label mt-4'
            ],
            'constraints' =>[
                new Assert\Length(['min' => 2, 'max' => 50]),
                new Assert\NotBlank()
            ]
        ])

        ->add('Salaire', TextType::class,[
            'attr' =>[
                'class' =>'form-control',
                'minlength' =>'2',
                'maxlength' => '50'
            ],
            'required'=> false,
            'label' => 'Salaire',
            'label_attr' =>[
                'class'=> 'form-label mt-4'
            ],
            'constraints' =>[
                new Assert\Length(['min' => 2, 'max' => 50]),
                new Assert\NotBlank()
            ]
        ])

        ->add('desciptionPoste', TextareaType::class, [
            'attr' =>[
                'class' =>'form-control',
                'min' => 1,
                'max' => 5
            ],
            'label' => 'Description du poste',
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
            'data_class' => Annonce::class,
        ]);
    }
}

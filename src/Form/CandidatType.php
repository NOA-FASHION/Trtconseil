<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;
class CandidatType extends AbstractType
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
                'label' => 'Nom du candidat',
                'label_attr' =>[
                    'class'=> 'form-label mt-4'
                ],
                'constraints' =>[
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('lastname', TextareaType::class, [
                'attr' =>[
                    'class' =>'form-control',
                    'min' => 1,
                    'max' => 5
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' =>[
                 new Assert\NotBlank(),
               
                ]
            ])
            ->add('cvLien', FileType::class, [
                'label' => 'Cv (PDF file)',

                'mapped' => false,

  
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            // ->add('cvLien' ,TextareaType::class, [
            //     'attr' =>[
            //         'class' =>'form-control',
            //         'min' => 1,
            //         'max' => 5
            //     ],
            //     'label' => 'Lien CV',
            //     'label_attr' => [
            //         'class' => 'form-label mt-4'
            //     ],
            //     'constraints' =>[
            //      new Assert\NotBlank(),
               
            //     ]
            // ])
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
            'data_class' => Candidat::class,
        ]);
    }
}

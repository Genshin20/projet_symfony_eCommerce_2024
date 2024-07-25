<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


              
        ->add('firstName', TextType::class,[
            'label'=>'Prenom',
            'attr'=>[
                'placeholder'=>'Philo',

            ]
            ])
            ->add('lastName', TextType::class,[
                'label' =>'Nom',
                'attr'=>[
                    'placeholder'=>'Faye',
    
                    ]
            ])
            ->add('telephone', TelType::class,[
                'label' =>'telephone',
                'attr'=>[
                    'placeholder'=>'',
                    ]
                    
            ])
            ->add('birthDate', null, [
                'widget' => 'single_text',
            ])
        

            ->add('email', EmailType::class,[
            'label'=> 'Email',
            'attr' => [
            'placeholder'=>'ave@exemple.com',
            ]
                
            ])
            
            ->add('password',RepeatedType::class,[
                'type'=>PasswordType::class,
                'invalid_message'=>'Les mots de passe doivent être identiques.',
                'first_options'=>[
                    'label'=> 'Mot de passe',
                    'attr'=> [
                    'placeholder'=>'S3CR3T',
                ],
                'constraints' =>[
                    new NotBlank(),
                    new Length([
                        'max'=> 4096,
                    ]),
                        //faire un regex une class
                new Regex(
                pattern:'/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/',
                message: 'Le mot de passe doit contenir 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial. Longueur entre 8 et 16 caractères.'
                ),
            ],
        ],
        'second_options' => [
            'label' => 'Confirmer le mot de passe',
            'attr'=>[
            'placeholder'=>'S3CR3T',
            ],
        ],
        //On mapped le mot de passe pou eviter  de voir en clair
        'mapped' => false,
    ]);

            
            
         
         
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin' => false,
        ]);
    }
}

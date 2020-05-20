<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('roles', CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'label' => false,
                    'choices' => [
                        'Formateur' => 'ROLE_FORMATEUR',
                        'Stagiaire' => 'ROLE_STAGIAIRE',
                    ],
                ],
            ])
            // ->add('roles', ChoiceType::class, [
            //     'choices' => [
            //         'Formateur' => 'ROLE_FORMATEUR',
            //         'Stagiaire' => 'ROLE_STAGIAIRE'
            //     ],
            //     'multiple' => true
            // ])
            ->add('password', PasswordType::class)
            ->add('nom')
            ->add('prenom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

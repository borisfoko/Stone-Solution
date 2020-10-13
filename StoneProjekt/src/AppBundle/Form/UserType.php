<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => ' ',
                'attr' => array(
                     'placeholder' => 'Matrikelnummer'
                )
                ))
            ->add('vorname', TextType::class, array(
                'label' => ' ',
                'attr' => array(
                     'placeholder' => 'Vorname'
                )
                ))
            ->add('nachname', TextType::class, array(
                'label' => ' ',
                'attr' => array(
                    'placeholder' => 'Nachname'
                )
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => '', 'attr' => array('placeholder' => 'Passwort')),
                'second_options' => array('label' => '', 'attr' => array('placeholder' => 'Passwort wiederholen')),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'validation_groups' => ['Default', 'Registration'],
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_user_type';
    }
}

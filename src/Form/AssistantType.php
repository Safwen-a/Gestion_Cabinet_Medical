<?php

namespace App\Form;

use App\Entity\Assistant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssistantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fname')
            ->add('lname')
            ->add('numTel')
            ->add('email')
            ->add('dateNaissance')
            ->add('adress')
            ->add('privilege')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assistant::class,
        ]);
    }
}

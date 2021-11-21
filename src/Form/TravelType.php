<?php

namespace App\Form;

use App\Entity\Travel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TravelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('hook')
            ->add('description')
            ->add('price')
            ->add('image1')
            ->add('image2')
            ->add('image3')
            ->add('pdf')
            ->add('category')
            ->add('tag')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Travel::class,
        ]);
    }
}

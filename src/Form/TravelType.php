<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Travel;
use App\Entity\Tags;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TravelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('hook')
            ->add('description')
            ->add('price')
            ->add('image1', FileType::class, [
                'label' => 'Image1',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ])
            ->add('image2', FileType::class, [
                'label' => 'Image2',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ])
            ->add('image3', FileType::class, [
                'label' => 'Image3',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ])
            ->add('pdf', FileType::class, [
                'label' => 'pdf',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Pdf document',
                    ])
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'choice_label'=>'name',
                'required' => true
            ])
            ->add('tag', EntityType::class, [
                'class' => Tags::class,
                'multiple' => true,
                'choice_label' => 'name',
                'expanded' => true,
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Travel::class,
        ]);
    }
}

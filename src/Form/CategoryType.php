<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('parentId')
            ->add('name', TextType::class)
            ->add('metaTitle', TextType::class)
            ->add('metaKeywords', TextType::class)
            ->add('metaDescription', TextType::class)
            ->add('description', TextareaType::class)
            ->add('url', TextType::class)
            ->add('image', TextType::class)
            ->add('position', IntegerType::class)
            ->add('visible', CheckboxType::class)
            ->add('externalId', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}

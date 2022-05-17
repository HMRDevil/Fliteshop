<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Brand;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class)
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
                ])
            ->add('name', TextType::class)
            ->add('annotation', TextareaType::class)
            ->add('body', TextareaType::class)
            ->add('visible', CheckboxType::class)
            ->add('position')
            ->add('metaTitle', TextType::class)
            ->add('metaKeywords', TextType::class)
            ->add('metaDescription', TextType::class)
            ->add('featured', CheckboxType::class)
            ->add('externalId', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Coupon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class CouponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class)
            ->add('expire', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('expires', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    '$' => Coupon::COUPON_ABSOLUTE,
                    '%' => Coupon::COUPON_PERCENTAGE,
                ]
            ])
            ->add('value', NumberType::class, [
                'scale' => 2,
            ])
            ->add('minOrderPrice', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('single', CheckboxType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coupon::class,
        ]);
    }
}

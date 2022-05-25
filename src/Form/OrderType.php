<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Новый' => Order::ORDER_STATUS_NEW,
                    'Принят' => Order::ORDER_STATUS_ASSEPTED,
                    'Выполнен' => Order::ORDER_STATUS_COMPLETED,
                    'Удален' => Order::ORDER_STATUS_DELETED
                ]
            ])
            ->add('deliveryId')
            ->add('deliveryPrice')
            ->add('paymentMethodId')
            ->add('paid')
            ->add('paymentDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('closed')
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('userId')
            ->add('name')
            ->add('address')
            ->add('phone')
            ->add('email')
            ->add('comment')
            ->add('url')
            ->add('paymentDetails')
            ->add('ip')
            ->add('totalPrice')
            ->add('note')
            ->add('discount')
            ->add('couponDiscount')
            ->add('couponCode')
            ->add('separateDelivery')
            ->add('modified', DateTimeType::class, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}

<?php

namespace App\Entity;

use App\Repository\DeliveryPaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_delivery_payment")
 * @ORM\Entity(repositoryClass=DeliveryPaymentRepository::class)
 */
class DeliveryPayment
{
    /**
     * @ORM\Column(name="delivery_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $deliveryId;

    /**
     * @ORM\Column(name="payment_method_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $paymentMethodId;

    public function getDeliveryId(): ?int
    {
        return $this->deliveryId;
    }

    public function getPaymentMethodId(): ?int
    {
        return $this->paymentMethodId;
    }
}

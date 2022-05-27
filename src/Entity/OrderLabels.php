<?php

namespace App\Entity;

use App\Repository\OrderLabelsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_orders_labels")
 * @ORM\Entity(repositoryClass=OrderLabelsRepository::class)
 */
class OrderLabels
{
    /**
     * @ORM\Column(name="order_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $orderId;

    /**
     * @ORM\Column(name="label_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $labelId;

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function getLabelId(): ?int
    {
        return $this->labelId;
    }
}

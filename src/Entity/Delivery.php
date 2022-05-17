<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_delivery", indexes={@ORM\Index(name="position", columns={"position"})})
 * @ORM\Entity(repositoryClass=DeliveryRepository::class)
 */
class Delivery
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="free_from", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $freeFrom = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $price = '0.00';

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

    /**
     * @var int|null
     *
     * @ORM\Column(name="separate_payment", type="integer", nullable=true)
     */
    private $separatePayment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFreeFrom(): ?string
    {
        return $this->freeFrom;
    }

    public function setFreeFrom(string $freeFrom): self
    {
        $this->freeFrom = $freeFrom;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getSeparatePayment(): ?int
    {
        return $this->separatePayment;
    }

    public function setSeparatePayment(?int $separatePayment): self
    {
        $this->separatePayment = $separatePayment;

        return $this;
    }
}

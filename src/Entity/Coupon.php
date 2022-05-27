<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_coupons", indexes={@ORM\Index(name="type_id", columns={"type"})})
 * @ORM\Entity(repositoryClass=CouponRepository::class)
 */
class Coupon
{
    const COUPON_ABSOLUTE = 'absolute';
    const COUPON_PERCENTAGE = 'percentage';

    /**
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="code", type="string", length=256, nullable=false)
     */
    private $code;

    /**
     * @ORM\Column(name="expire", type="date", nullable=true)
     */
    private $expire;

    /**
     * @ORM\Column(name="type", type="text", nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(name="value", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $value;

    /**
     * @ORM\Column(name="min_order_price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $minOrderPrice;

    /**
     * @ORM\Column(name="single", type="integer", nullable=false)
     */
    private $single;

    /**
     * @ORM\Column(name="usages", type="integer", nullable=false)
     */
    private $usages;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getExpire(): ?\DateTimeInterface
    {
        return $this->expire;
    }

    public function setExpire(?\DateTimeInterface $expire): self
    {
        $this->expire = $expire;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getMinOrderPrice(): ?string
    {
        return $this->minOrderPrice;
    }

    public function setMinOrderPrice(?string $minOrderPrice): self
    {
        $this->minOrderPrice = $minOrderPrice;

        return $this;
    }

    public function getSingle(): ?int
    {
        return $this->single;
    }

    public function setSingle(int $single): self
    {
        $this->single = $single;

        return $this;
    }

    public function getUsages(): ?int
    {
        return $this->usages;
    }

    public function setUsages(int $usages): self
    {
        $this->usages = $usages;

        return $this;
    }
}

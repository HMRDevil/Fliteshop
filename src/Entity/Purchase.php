<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_purchases", indexes={@ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="order_id", columns={"order_id"}), @ORM\Index(name="variant_id", columns={"variant_id"})})
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 */
class Purchase
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
     * @var int
     *
     * @ORM\Column(name="order_id", type="integer", nullable=false)
     */
    private $orderId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="product_id", type="integer", nullable=true)
     */
    private $productId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="variant_id", type="integer", nullable=true)
     */
    private $variantId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255, nullable=false)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="variant_name", type="string", length=255, nullable=false)
     */
    private $variantName;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $price = '0.00';

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=255, nullable=false)
     */
    private $sku;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(?int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getVariantId(): ?int
    {
        return $this->variantId;
    }

    public function setVariantId(?int $variantId): self
    {
        $this->variantId = $variantId;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getVariantName(): ?string
    {
        return $this->variantName;
    }

    public function setVariantName(string $variantName): self
    {
        $this->variantName = $variantName;

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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }
}

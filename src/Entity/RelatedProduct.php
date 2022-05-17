<?php

namespace App\Entity;

use App\Repository\RelatedProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_related_products", indexes={@ORM\Index(name="position", columns={"position"})})
 * @ORM\Entity(repositoryClass=RelatedProductRepository::class)
 */
class RelatedProduct
{
    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $productId;

    /**
     * @var int
     *
     * @ORM\Column(name="related_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $relatedId;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function getRelatedId(): ?int
    {
        return $this->relatedId;
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
}

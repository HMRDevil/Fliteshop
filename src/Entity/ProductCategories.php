<?php

namespace App\Entity;

use App\Repository\ProductCategoriesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_products_categories", indexes={@ORM\Index(name="position", columns={"position"}), @ORM\Index(name="category_id", columns={"category_id"}), @ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity(repositoryClass=ProductCategoriesRepository::class)
 */
class ProductCategories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="categoryProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }
    
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }
    
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
}

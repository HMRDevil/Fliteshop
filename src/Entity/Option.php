<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_options", indexes={@ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="value", columns={"value"}), @ORM\Index(name="feature_id", columns={"feature_id"})})
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 */
class Option
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="options")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Feature::class, inversedBy="options", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $feature;

    /**
     * @ORM\Column(name="value", type="string", length=500, nullable=false)
     */
    private $value;

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

    public function getFeature(): ?Feature
    {
        return $this->feature;
    }
    
    public function setFeature(?Feature $feature): self
    {
        $this->feature = $feature;

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
}

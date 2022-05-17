<?php

namespace App\Entity;

use App\Repository\FeatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_features", indexes={@ORM\Index(name="in_filter", columns={"in_filter"}), @ORM\Index(name="position", columns={"position"})})
 * @ORM\Entity(repositoryClass=FeatureRepository::class)
 */
class Feature
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

    /**
     * @ORM\Column(name="in_filter", type="boolean", nullable=true)
     */
    private $inFilter;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="features")
     */
    private $categories;
    
    /**
     * @ORM\OneToMany(targetEntity=Option::class, mappedBy="feature")
     */
    private $options;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->options = new ArrayCollection();
    }

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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getInFilter(): ?bool
    {
        return $this->inFilter;
    }

    public function setInFilter(?bool $inFilter): self
    {
        $this->inFilter = $inFilter;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addFeature($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeFeature($this);
        }

        return $this;
    }
    
    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOptions(Option $options): self
    {
        if (!$this->options->contains($options)) {
            $this->options[] = $options;
            $options->setProduct($this);
        }

        return $this;
    }

    public function removeOptions(Option $options): self
    {
        if ($this->options->removeElement($options)) {
            // set the owning side to null (unless already changed)
            if ($options->getProduct() === $this) {
                $options->setProduct(null);
            }
        }

        return $this;
    }
}
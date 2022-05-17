<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_categories", indexes={@ORM\Index(name="parent_id", columns={"parent_id"}), @ORM\Index(name="visible", columns={"visible"}), @ORM\Index(name="url", columns={"url"}), @ORM\Index(name="position", columns={"position"}), @ORM\Index(name="external_id", columns={"external_id"})})
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="parent_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parentId;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=false)
     */
    private $metaTitle;

    /**
     * @ORM\Column(name="meta_keywords", type="string", length=255, nullable=false)
     */
    private $metaKeywords;

    /**
     * @ORM\Column(name="meta_description", type="string", length=255, nullable=false)
     */
    private $metaDescription;

    /**
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

    /**
     * @ORM\Column(name="visible", type="boolean", nullable=false, options={"default"="1"})
     */
    private $visible = true;

    /**
     * @ORM\Column(name="external_id", type="string", length=36, nullable=false)
     */
    private $externalId;

    /**
     * @ORM\ManyToMany(targetEntity=Feature::class, inversedBy="categories")
     * @ORM\JoinTable(name="s_categories_features")
     */
    private $features;
    
    /**
     * @ORM\OneToMany(targetEntity=ProductCategories::class, mappedBy="category")
     */
    private $categoryProducts;

    public function __construct()
    {
        $this->features = new ArrayCollection();
        $this->categoryProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
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

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(string $metaTitle): self
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(string $metaKeywords): self
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return Collection<int, Feature>
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(Feature $feature): self
    {
        if (!$this->features->contains($feature)) {
            $this->features[] = $feature;
        }

        return $this;
    }

    public function removeFeature(Feature $feature): self
    {
        $this->features->removeElement($feature);

        return $this;
    }
    
    /**
     * @return Collection|ProductCategories[]
     */
    public function getCategoryProducts(): Collection
    {
        return $this->categoryProducts;
    }

    public function addProductCategories(ProductCategories $categoryProducts): self
    {
        if (!$this->categoryProducts->contains($categoryProducts)) {
            $this->categoryProducts[] = $categoryProducts;
            $categoryProducts->setCategory($this);
        }

        return $this;
    }

    public function removeProductCategories(ProductCategories $categoryProducts): self
    {
        if ($this->categoryProducts->removeElement($categoryProducts)) {
            // set the owning side to null (unless already changed)
            if ($categoryProducts->getCategory() === $this) {
                $categoryProducts->setCategory(null);
            }
        }

        return $this;
    }
}

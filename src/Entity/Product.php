<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_products", indexes={@ORM\Index(name="brand_id", columns={"brand_id"}), @ORM\Index(name="position", columns={"position"}), @ORM\Index(name="hit", columns={"featured"}), @ORM\Index(name="url", columns={"url"}), @ORM\Index(name="visible", columns={"visible"}), @ORM\Index(name="external_id", columns={"external_id"}), @ORM\Index(name="name", columns={"name"})})
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="product")
     * @ORM\JoinColumn(nullable=true)
     */
    private $brand;

    /**
     * @ORM\Column(name="name", type="string", length=500, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="annotation", type="text", length=65535, nullable=false)
     */
    private $annotation;

    /**
     * @ORM\Column(name="body", type="text", length=0, nullable=false)
     */
    private $body;

    /**
     * @ORM\Column(name="visible", type="boolean", nullable=false, options={"default"="1"})
     */
    private $visible;

    /**
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

    /**
     * @ORM\Column(name="meta_title", type="string", length=500, nullable=false)
     */
    private $metaTitle;

    /**
     * @ORM\Column(name="meta_keywords", type="string", length=500, nullable=false)
     */
    private $metaKeywords;

    /**
     * @ORM\Column(name="meta_description", type="string", length=500, nullable=false)
     */
    private $metaDescription;

    /**
     * @ORM\Column(name="created", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $created;

    /**
     * @ORM\Column(name="featured", type="boolean", nullable=true)
     */
    private $featured;

    /**
     * @ORM\Column(name="external_id", type="string", length=36, nullable=false)
     */
    private $externalId;
    
    /**
     * @ORM\OneToMany(targetEntity=Variant::class, mappedBy="product")
     */
    private $variant;
    
    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="product", fetch="EAGER")
     */
    private $image;
    
    /**
     * @ORM\OneToMany(targetEntity=ProductCategories::class, mappedBy="product")
     */
    private $productCategories;
    
    /**
     * @ORM\OneToMany(targetEntity=Option::class, mappedBy="product")
     */
    private $options;
    
    public function __construct()
    {
        $this->variant = new ArrayCollection();
        $this->image = new ArrayCollection();
        $this->productCategories = new ArrayCollection();
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

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

    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }

    public function setAnnotation(string $annotation): self
    {
        $this->annotation = $annotation;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getFeatured(): ?bool
    {
        return $this->featured;
    }

    public function setFeatured(?bool $featured): self
    {
        $this->featured = $featured;

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
     * @return Collection|ProductCategories[]
     */
    public function getProductCategories(): Collection
    {
        return $this->productCategories;
    }

    public function addProductCategories(ProductCategories $productCategories): self
    {
        if (!$this->productCategories->contains($productCategories)) {
            $this->productCategories[] = $productCategories;
            $productCategories->setProduct($this);
        }

        return $this;
    }

    public function removeProductCategories(ProductCategories $productCategories): self
    {
        if ($this->productCategories->removeElement($productCategories)) {
            // set the owning side to null (unless already changed)
            if ($productCategories->getProduct() === $this) {
                $productCategories->setProduct(null);
            }
        }

        return $this;
    }
    
    /**
     * @return Collection|Image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }
    
    /**
     * @return Collection|Variant[]
     */
    public function getVariant(): Collection
    {
        return $this->variant;
    }

    public function addVariant(Variant $variant): self
    {
        if (!$this->variant->contains($variant)) {
            $this->variant[] = $variant;
            $variant->setProduct($this);
        }

        return $this;
    }

    public function removeVariant(Variant $variant): self
    {
        if ($this->variant->removeElement($variant)) {
            // set the owning side to null (unless already changed)
            if ($variant->getProduct() === $this) {
                $variant->setProduct(null);
            }
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

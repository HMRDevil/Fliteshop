<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_blog", indexes={@ORM\Index(name="url", columns={"url"}), @ORM\Index(name="enabled", columns={"visible"})})
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
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
     * @ORM\Column(name="name", type="string", length=500, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=500, nullable=false)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="string", length=500, nullable=false)
     */
    private $metaKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=500, nullable=false)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="annotation", type="text", length=65535, nullable=false)
     */
    private $annotation;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=0, nullable=false)
     */
    private $text;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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

    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }

    public function setAnnotation(string $annotation): self
    {
        $this->annotation = $annotation;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}

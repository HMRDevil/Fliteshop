<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_pages", indexes={@ORM\Index(name="url", columns={"url"}), @ORM\Index(name="order_num", columns={"position"})})
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="meta_title", type="string", length=500, nullable=false)
     */
    private $metaTitle;

    /**
     * @ORM\Column(name="meta_description", type="string", length=500, nullable=false)
     */
    private $metaDescription;

    /**
     * @ORM\Column(name="meta_keywords", type="string", length=500, nullable=false)
     */
    private $metaKeywords;

    /**
     * @ORM\Column(name="body", type="text", length=0, nullable=false)
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $menu;

    /**
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

    /**
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible;

    /**
     * @ORM\Column(name="header", type="string", length=1024, nullable=false)
     */
    private $header;

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

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

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

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(string $header): self
    {
        $this->header = $header;

        return $this;
    }
}

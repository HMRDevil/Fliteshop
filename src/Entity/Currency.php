<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_currencies", indexes={@ORM\Index(name="position", columns={"position"})})
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 */
class Currency
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="sign", type="string", length=20, nullable=false)
     */
    private $sign;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=3, nullable=false, options={"fixed"=true})
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="rate_from", type="decimal", precision=10, scale=2, nullable=false, options={"default"="1.00"})
     */
    private $rateFrom = '1.00';

    /**
     * @var string
     *
     * @ORM\Column(name="rate_to", type="decimal", precision=10, scale=2, nullable=false, options={"default"="1.00"})
     */
    private $rateTo = '1.00';

    /**
     * @var int
     *
     * @ORM\Column(name="cents", type="integer", nullable=false, options={"default"="2"})
     */
    private $cents = 2;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="enabled", type="integer", nullable=false)
     */
    private $enabled;

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

    public function getSign(): ?string
    {
        return $this->sign;
    }

    public function setSign(string $sign): self
    {
        $this->sign = $sign;

        return $this;
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

    public function getRateFrom(): ?string
    {
        return $this->rateFrom;
    }

    public function setRateFrom(string $rateFrom): self
    {
        $this->rateFrom = $rateFrom;

        return $this;
    }

    public function getRateTo(): ?string
    {
        return $this->rateTo;
    }

    public function setRateTo(string $rateTo): self
    {
        $this->rateTo = $rateTo;

        return $this;
    }

    public function getCents(): ?int
    {
        return $this->cents;
    }

    public function setCents(int $cents): self
    {
        $this->cents = $cents;

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

    public function getEnabled(): ?int
    {
        return $this->enabled;
    }

    public function setEnabled(int $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
}

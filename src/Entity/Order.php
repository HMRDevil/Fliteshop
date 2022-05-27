<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="s_orders", indexes={@ORM\Index(name="written_off", columns={"closed"}), @ORM\Index(name="status", columns={"status"}), @ORM\Index(name="payment_status", columns={"paid"}), @ORM\Index(name="login", columns={"user_id"}), @ORM\Index(name="date", columns={"date"}), @ORM\Index(name="code", columns={"url"})})
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 */
class Order
{
    public const ORDER_STATUS_NEW = 0;
    public const ORDER_STATUS_ASSEPTED = 1;
    public const ORDER_STATUS_COMPLETED = 2;
    public const ORDER_STATUS_DELETED = 3;
    
    /**
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="delivery_id", type="integer", nullable=true)
     */
    private $deliveryId;

    /**
     * @ORM\Column(name="delivery_price", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $deliveryPrice;

    /**
     * @ORM\Column(name="payment_method_id", type="integer", nullable=true)
     */
    private $paymentMethodId;

    /**
     * @ORM\Column(name="paid", type="integer", nullable=false)
     */
    private $paid;

    /**
     * @ORM\Column(name="payment_date", type="datetime", nullable=false)
     */
    private $paymentDate;

    /**
     * @ORM\Column(name="closed", type="boolean", nullable=false)
     */
    private $closed;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @ORM\Column(name="phone", type="string", length=255, nullable=false)
     */
    private $phone;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(name="comment", type="string", length=1024, nullable=false)
     */
    private $comment;

    /**
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(name="payment_details", type="text", length=65535, nullable=false)
     */
    private $paymentDetails;

    /**
     * @ORM\Column(name="ip", type="string", length=15, nullable=false)
     */
    private $ip;

    /**
     * @ORM\Column(name="total_price", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $totalPrice;

    /**
     * @ORM\Column(name="note", type="string", length=1024, nullable=false)
     */
    private $note;

    /**
     * @ORM\Column(name="discount", type="decimal", precision=5, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $discount;

    /**
     * @ORM\Column(name="coupon_discount", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $couponDiscount;

    /**
     * @ORM\Column(name="coupon_code", type="string", length=255, nullable=false)
     */
    private $couponCode;

    /**
     * @ORM\Column(name="separate_delivery", type="integer", nullable=false)
     */
    private $separateDelivery;

    /**
     * @ORM\Column(name="modified", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $modified;

    /**
     * @ORM\ManyToMany(targetEntity=Label::class, inversedBy="orders")
     * @ORM\JoinTable(name="s_orders_labels")
     */
    private $label;

    public function __construct()
    {
        $this->label = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDeliveryId(): ?int
    {
        return $this->deliveryId;
    }

    public function setDeliveryId(?int $deliveryId): self
    {
        $this->deliveryId = $deliveryId;

        return $this;
    }

    public function getDeliveryPrice(): ?string
    {
        return $this->deliveryPrice;
    }

    public function setDeliveryPrice(string $deliveryPrice): self
    {
        $this->deliveryPrice = $deliveryPrice;

        return $this;
    }

    public function getPaymentMethodId(): ?int
    {
        return $this->paymentMethodId;
    }

    public function setPaymentMethodId(?int $paymentMethodId): self
    {
        $this->paymentMethodId = $paymentMethodId;

        return $this;
    }

    public function getPaid(): ?int
    {
        return $this->paid;
    }

    public function setPaid(int $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function getClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): self
    {
        $this->closed = $closed;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPaymentDetails(): ?string
    {
        return $this->paymentDetails;
    }

    public function setPaymentDetails(string $paymentDetails): self
    {
        $this->paymentDetails = $paymentDetails;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(string $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getCouponDiscount(): ?string
    {
        return $this->couponDiscount;
    }

    public function setCouponDiscount(string $couponDiscount): self
    {
        $this->couponDiscount = $couponDiscount;

        return $this;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function setCouponCode(string $couponCode): self
    {
        $this->couponCode = $couponCode;

        return $this;
    }

    public function getSeparateDelivery(): ?int
    {
        return $this->separateDelivery;
    }

    public function setSeparateDelivery(int $separateDelivery): self
    {
        $this->separateDelivery = $separateDelivery;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * @return Collection<int, Label>
     */
    public function getLabel(): Collection
    {
        return $this->label;
    }

    public function addLabel(Label $label): self
    {
        if (!$this->label->contains($label)) {
            $this->label[] = $label;
        }

        return $this;
    }

    public function removeLabel(Label $label): self
    {
        $this->label->removeElement($label);

        return $this;
    }
}

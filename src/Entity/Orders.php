<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 */
class Orders
{
    const PAY_TYPE_PAYPAL = 'paypal';
    const PAY_TYPE_CARD = 'card';

    const STATUS_CREATED = 'waiting_for_pay';
    const STATUS_SUCCESS_PAYMENT = 'success';
    const STATUS_FAILED_PAYMENT = 'failed';
    const STATUS_CANCELED_PAYMENT = 'canceled';
    const STATUS_APPROVED_PAYMENT = 'approved';
    const STATUS_SENT_PAYMENT = 'sent';
    const STATUS_COMPLETED_PAYMENT = 'completed';

    const STATUSES_ARRAY = [
        self::STATUS_CREATED,
        self::STATUS_SUCCESS_PAYMENT,
        self::STATUS_FAILED_PAYMENT,
        self::STATUS_APPROVED_PAYMENT,
        self::STATUS_SENT_PAYMENT,
        self::STATUS_COMPLETED_PAYMENT,
        self::STATUS_CANCELED_PAYMENT,
    ];

    const NEED_PAYMENT_STATUSES_ARRAY = [
        self::STATUS_FAILED_PAYMENT,
        self::STATUS_CREATED
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $full_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pay_status;

    /**
     * @ORM\Column(type="json")
     */
    private $order_data = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $pay_pal_data = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_updated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?int
    {
        return $this->zip;
    }

    public function setZip(int $zip): self
    {
        $this->zip = $zip;

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

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getPayStatus(): ?string
    {
        return $this->pay_status;
    }

    public function setPayStatus(string $pay_status): self
    {
        $this->pay_status = $pay_status;

        return $this;
    }

    public function getOrderData(): ?array
    {
        return $this->order_data;
    }

    public function setOrderData(array $order_data): self
    {
        $this->order_data = $order_data;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPayPalData(): ?array
    {
        return $this->pay_pal_data;
    }

    public function setPayPalData(array $pay_pal_data): self
    {
        $this->pay_pal_data = $pay_pal_data;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->date_updated;
    }

    public function setDateUpdated(\DateTimeInterface $date_updated): self
    {
        $this->date_updated = $date_updated;

        return $this;
    }
}

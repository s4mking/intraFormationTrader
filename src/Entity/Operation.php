<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $symbol = null;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?float $lots = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $openTime = null;

    #[ORM\Column(nullable: true)]
    private ?float $openPrice = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $closeTime = null;

    #[ORM\Column(nullable: true)]
    private ?float $closePrice = null;

    #[ORM\Column(nullable: true)]
    private ?float $profit = null;

    #[ORM\Column(nullable: true)]
    private ?float $netProfit = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $transmitter = null;

    #[ORM\Column(type: 'boolean', options: ["default" => true])]
    private $isVerified = true;

    #[ORM\Column(type: 'boolean', options: ["default" => true])]
    private $isApproved = true;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(?string $symbol): static
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLots(): ?float
    {
        return $this->lots;
    }

    public function setLots(?float $lots): static
    {
        $this->lots = $lots;

        return $this;
    }

    public function getOpenTime(): ?\DateTimeInterface
    {
        return $this->openTime;
    }

    public function setOpenTime(\DateTimeInterface $openTime): static
    {
        $this->openTime = $openTime;

        return $this;
    }

    public function getOpenPrice(): ?float
    {
        return $this->openPrice;
    }

    public function setOpenPrice(?float $openPrice): static
    {
        $this->openPrice = $openPrice;

        return $this;
    }

    public function getCloseTime(): ?\DateTimeInterface
    {
        return $this->closeTime;
    }

    public function setCloseTime(?\DateTimeInterface $closeTime): static
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    public function getClosePrice(): ?float
    {
        return $this->closePrice;
    }

    public function setClosePrice(?float $closePrice): static
    {
        $this->closePrice = $closePrice;

        return $this;
    }

    public function getProfit(): ?float
    {
        return $this->profit;
    }

    public function setProfit(?float $profit): static
    {
        $this->profit = $profit;

        return $this;
    }

    public function getNetProfit(): ?float
    {
        return $this->netProfit;
    }

    public function setNetProfit(?float $netProfit): static
    {
        $this->netProfit = $netProfit;

        return $this;
    }

    public function getTransmitter(): ?User
    {
        return $this->transmitter;
    }

    public function setTransmitter(?User $transmitter): static
    {
        $this->transmitter = $transmitter;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * @param bool $isVerified
     */
    public function setIsVerified(bool $isVerified): void
    {
        $this->isVerified = $isVerified;
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->isApproved;
    }

    /**
     * @param bool $isApproved
     */
    public function setIsApproved(bool $isApproved): void
    {
        $this->isApproved = $isApproved;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}

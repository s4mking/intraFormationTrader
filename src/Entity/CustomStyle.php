<?php

namespace App\Entity;

use App\Repository\CustomStyleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomStyleRepository::class)]
class CustomStyle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $BackgroundImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LogoFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailAdmin = null;

    #[ORM\Column(type: 'integer', options: ['default' => 1])]
    private ?int $styleId = 1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->BackgroundImage;
    }

    public function setBackgroundImage(?string $BackgroundImage): static
    {
        $this->BackgroundImage = $BackgroundImage;

        return $this;
    }

    public function getLogoFile(): ?string
    {
        return $this->LogoFile;
    }

    public function setLogoFile(?string $LogoFile): static
    {
        $this->LogoFile = $LogoFile;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailAdmin(): ?string
    {
        return $this->emailAdmin;
    }

    /**
     * @param string|null $emailAdmin
     */
    public function setEmailAdmin(?string $emailAdmin): void
    {
        $this->emailAdmin = $emailAdmin;
    }

    public function getStyleId(): ?int
    {
        return $this->styleId;
    }

    public function setStyleId(?int $styleId): void
    {
        $this->styleId = $styleId;
    }
}

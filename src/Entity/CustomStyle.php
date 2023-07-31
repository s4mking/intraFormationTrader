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
}

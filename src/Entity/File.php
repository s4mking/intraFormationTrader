<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity]
#[Vich\Uploadable]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'user_files', fileNameProperty: 'filename')]
    private ?SymfonyFile $file = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $filename = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'files')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    // Propriété non mappée pour le directory_namer
    private ?string $userDirectory = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?SymfonyFile
    {
        return $this->file;
    }

    public function setFile(?SymfonyFile $file): self
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        // Définir le userDirectory basé sur le nom et prénom de l'utilisateur
        if ($user) {
            $nom = ucfirst(strtolower($user->getNom()));
            $prenom = ucfirst(strtolower($user->getPrenom()));
            $this->userDirectory = $nom . '-' . $prenom;
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getUserDirectory(): ?string
    {
        // Si userDirectory n'est pas défini, le calculer à partir de l'utilisateur
        if ($this->userDirectory === null && $this->user) {
            $nom = ucfirst(strtolower($this->user->getNom()));
            $prenom = ucfirst(strtolower($this->user->getPrenom()));
            $this->userDirectory = $nom . '-' . $prenom;
        }
        return $this->userDirectory;
    }
}

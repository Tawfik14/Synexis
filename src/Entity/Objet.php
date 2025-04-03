<?php

namespace App\Entity;

use App\Repository\ObjetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjetRepository::class)]
#[ORM\Table(name: "connected_object")]
class Objet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "string", length: 100)]
    private string $type;

    #[ORM\Column(type: "string", length: 50)]
    private string $status;

    #[ORM\Column(type: "string", length: 255)]
    private string $location;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $room = null;

    #[ORM\Column(name: "last_used_at", type: "datetime", nullable: true)]
    private ?\DateTimeInterface $lastUsedAt = null;

    #[ORM\Column(name: "owner_id", type: "integer", nullable: true)]
    private ?int $ownerId = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $brand = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    // Getters and setters à ajouter ici si nécessaire
        public function getId(): int
        {
            return $this->id;
        }
    
        public function getName(): string
        {
            return $this->name;
        }
    
        public function setName(string $name): self
        {
            $this->name = $name;
            return $this;
        }
    
        public function getType(): string
        {
            return $this->type;
        }
    
        public function setType(string $type): self
        {
            $this->type = $type;
            return $this;
        }
    
        public function getStatus(): string
        {
            return $this->status;
        }
    
        public function setStatus(string $status): self
        {
            $this->status = $status;
            return $this;
        }
    
        public function getLocation(): string
        {
            return $this->location;
        }
    
        public function setLocation(string $location): self
        {
            $this->location = $location;
            return $this;
        }
    
        public function getCreatedAt(): \DateTimeInterface
        {
            return $this->createdAt;
        }
    
        public function setCreatedAt(\DateTimeInterface $createdAt): self
        {
            $this->createdAt = $createdAt;
            return $this;
        }
    
        public function getRoom(): ?string
        {
            return $this->room;
        }
    
        public function setRoom(?string $room): self
        {
            $this->room = $room;
            return $this;
        }
    
        public function getLastUsedAt(): ?\DateTimeInterface
        {
            return $this->lastUsedAt;
        }
    
        public function setLastUsedAt(?\DateTimeInterface $lastUsedAt): self
        {
            $this->lastUsedAt = $lastUsedAt;
            return $this;
        }
    
        public function getOwnerId(): ?int
        {
            return $this->ownerId;
        }
    
        public function setOwnerId(?int $ownerId): self
        {
            $this->ownerId = $ownerId;
            return $this;
        }
    
        public function getBrand(): ?string
        {
            return $this->brand;
        }
    
        public function setBrand(?string $brand): self
        {
            $this->brand = $brand;
            return $this;
        }
    
        public function getDescription(): ?string
        {
            return $this->description;
        }
    
        public function setDescription(?string $description): self
        {
            $this->description = $description;
            return $this;
        }
    
        #[ORM\ManyToOne(targetEntity: \App\Entity\User::class)]
        #[ORM\JoinColumn(name: "owner_id", referencedColumnName: "id", nullable: true)]
        private ?\App\Entity\User $user = null;

        public function getUser(): ?\App\Entity\User
        {
            return $this->user;
        }

        public function setUser(?\App\Entity\User $user): self
        {
            $this->user = $user;
            return $this;
        }

}

<?php

namespace App\Entity;

use App\Repository\DeleteObjetRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ConnectedObject;
use App\Entity\User;

#[ORM\Entity(repositoryClass: DeleteObjetRequestRepository::class)]
class DeleteObjetRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ConnectedObject::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ConnectedObject $objet = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?ConnectedObject
    {
        return $this->objet;
    }

    public function setObjet(ConnectedObject $objet): self
    {
        $this->objet = $objet;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}

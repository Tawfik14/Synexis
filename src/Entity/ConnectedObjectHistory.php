<?php

namespace App\Entity;

use App\Repository\ConnectedObjectHistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ConnectedObject;
use App\Entity\User;

#[ORM\Entity(repositoryClass: ConnectedObjectHistoryRepository::class)]
class ConnectedObjectHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ConnectedObject::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ConnectedObject $object = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $modifiedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $modifiedBy = null;

    #[ORM\Column(type: 'json')]
    private array $previousData = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?ConnectedObject
    {
        return $this->object;
    }

    public function setObject(?ConnectedObject $object): self
    {
        $this->object = $object;
        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy(?User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;
        return $this;
    }

    public function getPreviousData(): array
    {
        return $this->previousData;
    }

    public function setPreviousData(array $previousData): self
    {
        $this->previousData = $previousData;
        return $this;
    }
}


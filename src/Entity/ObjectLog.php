<?php

namespace App\Entity;

use App\Repository\ObjectLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjectLogRepository::class)]
#[ORM\Table(name: 'object_history')]
class ObjectLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: \App\Entity\ConnectedObject::class, cascade: ['persist'])]
    private $objet;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $objectName = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $action = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $performedBy = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet()
    {
        return $this->objet;
    }

    public function setObjet($objet): self
    {
        $this->objet = $objet;
        return $this;
    }

    public function getObjectName(): ?string
    {
        return $this->objectName;
    }

    public function setObjectName(?string $objectName): self
    {
        $this->objectName = $objectName;
        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;
        return $this;
    }

    public function getPerformedBy(): ?string
    {
        return $this->performedBy;
    }

    public function setPerformedBy(string $performedBy): self
    {
        $this->performedBy = $performedBy;
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
}

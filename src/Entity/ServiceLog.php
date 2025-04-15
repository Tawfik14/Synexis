<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ServiceLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $action = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $performedBy = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $serviceName = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int { return $this->id; }

    public function getAction(): ?string { return $this->action; }
    public function setAction(?string $action): self { $this->action = $action; return $this; }

    public function getPerformedBy(): ?string { return $this->performedBy; }
    public function setPerformedBy(?string $performedBy): self { $this->performedBy = $performedBy; return $this; }

    public function getServiceName(): ?string { return $this->serviceName; }
    public function setServiceName(?string $serviceName): self { $this->serviceName = $serviceName; return $this; }

    public function getCreatedAt(): ?\DateTimeInterface { return $this->createdAt; }
    public function setCreatedAt(?\DateTimeInterface $createdAt): self { $this->createdAt = $createdAt; return $this; }
}

<?php

namespace App\Entity;

use App\Repository\ConnectedObjectRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity(repositoryClass: ConnectedObjectRepository::class)]
#[UniqueEntity(fields:["name"], message:"Ce nom est déjà utilisé par un autre objet.")]
class ConnectedObject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $room = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lastUsedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $owner = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $uniqueId = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $currentTemp = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $targetTemp = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $mode = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $viewAngle = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $resolution = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $connectivity = null;

   #[ORM\Column(name: '`signal`', length: 50, nullable: true)]
private ?string $signal = null;


    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $batteryLevel = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $storageCapacity = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $ram = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $screenSize = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $os = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
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
public function __construct()
{
    $this->createdAt = new \DateTimeImmutable();
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;
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

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(?string $uniqueId): self
    {
        $this->uniqueId = $uniqueId;
        return $this;
    }

    public function getCurrentTemp(): ?float
    {
        return $this->currentTemp;
    }

    public function setCurrentTemp(?float $currentTemp): self
    {
        $this->currentTemp = $currentTemp;
        return $this;
    }

    public function getTargetTemp(): ?float
    {
        return $this->targetTemp;
    }

    public function setTargetTemp(?float $targetTemp): self
    {
        $this->targetTemp = $targetTemp;
        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(?string $mode): self
    {
        $this->mode = $mode;
        return $this;
    }

    public function getViewAngle(): ?int
    {
        return $this->viewAngle;
    }

    public function setViewAngle(?int $viewAngle): self
    {
        $this->viewAngle = $viewAngle;
        return $this;
    }

    public function getResolution(): ?string
    {
        return $this->resolution;
    }

    public function setResolution(?string $resolution): self
    {
        $this->resolution = $resolution;
        return $this;
    }

    public function getConnectivity(): ?string
    {
        return $this->connectivity;
    }

    public function setConnectivity(?string $connectivity): self
    {
        $this->connectivity = $connectivity;
        return $this;
    }

    public function getSignal(): ?string
    {
        return $this->signal;
    }

    public function setSignal(?string $signal): self
    {
        $this->signal = $signal;
        return $this;
    }

    public function getBatteryLevel(): ?int
    {
        return $this->batteryLevel;
    }

    public function setBatteryLevel(?int $batteryLevel): self
    {
        $this->batteryLevel = $batteryLevel;
        return $this;
    }

    public function getStorageCapacity(): ?int
    {
        return $this->storageCapacity;
    }

    public function setStorageCapacity(?int $storageCapacity): self
    {
        $this->storageCapacity = $storageCapacity;
        return $this;
    }

    public function getRam(): ?int
    {
        return $this->ram;
    }

    public function setRam(?int $ram): self
    {
        $this->ram = $ram;
        return $this;
    }

    public function getScreenSize(): ?float
    {
        return $this->screenSize;
    }

    public function setScreenSize(?float $screenSize): self
    {
        $this->screenSize = $screenSize;
        return $this;
    }

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(?string $os): self
    {
        $this->os = $os;
        return $this;
    }
}


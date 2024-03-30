<?php

namespace App\Entity;

use App\Repository\BloodTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BloodTypeRepository::class)]
class BloodType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'bloodType', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?HealthContainer $healthContainer = null;

    #[ORM\Column(length: 8)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHealthContainer(): ?HealthContainer
    {
        return $this->healthContainer;
    }

    public function setHealthContainer(HealthContainer $healthContainer): static
    {
        $this->healthContainer = $healthContainer;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }
}

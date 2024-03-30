<?php

namespace App\Entity;

use App\Repository\HeightRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeightRepository::class)]
class Height
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'height', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?HealthContainer $healthContainer = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $value = null;

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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }
}

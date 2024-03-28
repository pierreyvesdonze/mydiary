<?php

namespace App\Entity;

use App\Repository\HealthConditionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HealthConditionRepository::class)]
class HealthCondition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'healthConditions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HealthContainer $healthContainer = null;

    #[ORM\Column(length: 40)]
    private ?string $title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHealthContainer(): ?HealthContainer
    {
        return $this->healthContainer;
    }

    public function setHealthContainer(?HealthContainer $healthContainer): static
    {
        $this->healthContainer = $healthContainer;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
}

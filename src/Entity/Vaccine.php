<?php

namespace App\Entity;

use App\Repository\VaccineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VaccineRepository::class)]
class Vaccine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'vaccines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HealthContainer $healthContainer = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $injectionDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deadlineDate = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHealthContainer(): ?HealthContainer
    {
        return $this->healthContainer;
    }

    public function setHealthContainer(?HealthContainer $healthContainer): static
    {
        $this->healthContainer = $healthContainer;

        return $this;
    }

    public function getInjectionDate(): ?\DateTimeInterface
    {
        return $this->injectionDate;
    }

    public function setInjectionDate(?\DateTimeInterface $injectionDate): static
    {
        $this->injectionDate = $injectionDate;

        return $this;
    }

    public function getDeadlineDate(): ?\DateTimeInterface
    {
        return $this->deadlineDate;
    }

    public function setDeadlineDate(?\DateTimeInterface $deadlineDate): static
    {
        $this->deadlineDate = $deadlineDate;

        return $this;
    }
}

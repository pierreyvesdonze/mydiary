<?php

namespace App\Entity;

use App\Repository\HeightRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeightRepository::class)]
class Height
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'height', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?healthContainer $height = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeight(): ?healthContainer
    {
        return $this->height;
    }

    public function setHeight(healthContainer $height): static
    {
        $this->height = $height;

        return $this;
    }
}

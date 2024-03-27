<?php

namespace App\Entity;

use App\Repository\HealthContainerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HealthContainerRepository::class)]
class HealthContainer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'healthContainer', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $visibility = null;

    #[ORM\OneToMany(mappedBy: 'healthContainer', targetEntity: Vaccine::class)]
    private Collection $vaccines;

    #[ORM\OneToMany(mappedBy: 'healthContainer', targetEntity: Care::class)]
    private Collection $cares;

    #[ORM\OneToMany(mappedBy: 'healthContainer', targetEntity: Weight::class)]
    private Collection $weights;

    #[ORM\OneToOne(mappedBy: 'healthContainer', cascade: ['persist', 'remove'])]
    private ?Height $height = null;

    #[ORM\OneToOne(mappedBy: 'healthContainer', cascade: ['persist', 'remove'])]
    private ?BloodType $bloodType = null;

    public function __construct()
    {
        $this->vaccines = new ArrayCollection();
        $this->cares = new ArrayCollection();
        $this->weights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isVisibility(): ?bool
    {
        return $this->visibility;
    }

    public function setVisibility(bool $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * @return Collection<int, Vaccine>
     */
    public function getVaccines(): Collection
    {
        return $this->vaccines;
    }

    public function addVaccine(Vaccine $vaccine): static
    {
        if (!$this->vaccines->contains($vaccine)) {
            $this->vaccines->add($vaccine);
            $vaccine->setHealthContainer($this);
        }

        return $this;
    }

    public function removeVaccine(Vaccine $vaccine): static
    {
        if ($this->vaccines->removeElement($vaccine)) {
            // set the owning side to null (unless already changed)
            if ($vaccine->getHealthContainer() === $this) {
                $vaccine->setHealthContainer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Care>
     */
    public function getCares(): Collection
    {
        return $this->cares;
    }

    public function addCare(Care $care): static
    {
        if (!$this->cares->contains($care)) {
            $this->cares->add($care);
            $care->setHealthContainer($this);
        }

        return $this;
    }

    public function removeCare(Care $care): static
    {
        if ($this->cares->removeElement($care)) {
            // set the owning side to null (unless already changed)
            if ($care->getHealthContainer() === $this) {
                $care->setHealthContainer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Weight>
     */
    public function getWeights(): Collection
    {
        return $this->weights;
    }

    public function addWeight(Weight $weight): static
    {
        if (!$this->weights->contains($weight)) {
            $this->weights->add($weight);
            $weight->setHealthContainer($this);
        }

        return $this;
    }

    public function removeWeight(Weight $weight): static
    {
        if ($this->weights->removeElement($weight)) {
            // set the owning side to null (unless already changed)
            if ($weight->getHealthContainer() === $this) {
                $weight->setHealthContainer(null);
            }
        }

        return $this;
    }

    public function getHeight(): ?Height
    {
        return $this->height;
    }

    public function setHeight(Height $height): static
    {
        // set the owning side of the relation if necessary
        if ($height->getHealthContainer() !== $this) {
            $height->setHealthContainer($this);
        }

        $this->height = $height;

        return $this;
    }

    public function getBloodType(): ?BloodType
    {
        return $this->bloodType;
    }

    public function setBloodType(BloodType $bloodType): static
    {
        // set the owning side of the relation if necessary
        if ($bloodType->getHealthContainer() !== $this) {
            $bloodType->setHealthContainer($this);
        }

        $this->bloodType = $bloodType;

        return $this;
    }
}

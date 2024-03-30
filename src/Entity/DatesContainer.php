<?php

namespace App\Entity;

use App\Repository\DatesContainerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatesContainerRepository::class)]
class DatesContainer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'datesContainer', targetEntity: Date::class, cascade: ['persist', 'remove'])]
    private Collection $dateContent;

    #[ORM\OneToOne(inversedBy: 'datesContainer', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $visibility = null;

    public function __construct()
    {
        $this->dateContent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Date>
     */
    public function getDateContent(): Collection
    {
        return $this->dateContent;
    }

    public function addDateContent(Date $dateContent): static
    {
        if (!$this->dateContent->contains($dateContent)) {
            $this->dateContent->add($dateContent);
            $dateContent->setDatesContainer($this);
        }

        return $this;
    }

    public function removeDateContent(Date $dateContent): static
    {
        if ($this->dateContent->removeElement($dateContent)) {
            // set the owning side to null (unless already changed)
            if ($dateContent->getDatesContainer() === $this) {
                $dateContent->setDatesContainer(null);
            }
        }

        return $this;
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
}

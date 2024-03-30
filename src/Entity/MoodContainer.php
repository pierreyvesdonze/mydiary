<?php

namespace App\Entity;

use App\Repository\MoodContainerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoodContainerRepository::class)]
class MoodContainer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'moodContainer', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $visibility = null;

    #[ORM\OneToMany(mappedBy: 'moodContainer', targetEntity: Mood::class,  cascade: ['persist', 'remove'])]
    private Collection $moods;

    public function __construct()
    {
        $this->moods = new ArrayCollection();
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
     * @return Collection<int, Mood>
     */
    public function getMoods(): Collection
    {
        return $this->moods;
    }

    public function addMood(Mood $mood): static
    {
        if (!$this->moods->contains($mood)) {
            $this->moods->add($mood);
            $mood->setMoodContainer($this);
        }

        return $this;
    }

    public function removeMood(Mood $mood): static
    {
        if ($this->moods->removeElement($mood)) {
            // set the owning side to null (unless already changed)
            if ($mood->getMoodContainer() === $this) {
                $mood->setMoodContainer(null);
            }
        }

        return $this;
    }
}

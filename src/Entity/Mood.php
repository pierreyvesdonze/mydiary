<?php

namespace App\Entity;

use App\Repository\MoodRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoodRepository::class)]
class Mood
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'moods')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MoodContainer $moodContainer = null;

    #[ORM\Column(length: 64)]
    private ?string $dayMood = null;

    #[ORM\Column(length: 64)]
    private ?string $sleep = null;

    #[ORM\Column(length: 255)]
    private ?string $morningMood = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dayProgram = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dayFeeling = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $fallingAsleep = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoodContainer(): ?MoodContainer
    {
        return $this->moodContainer;
    }

    public function setMoodContainer(?MoodContainer $moodContainer): static
    {
        $this->moodContainer = $moodContainer;

        return $this;
    }

    public function getDayMood(): ?string
    {
        return $this->dayMood;
    }

    public function setDayMood(string $dayMood): static
    {
        $this->dayMood = $dayMood;

        return $this;
    }

    public function getSleep(): ?string
    {
        return $this->sleep;
    }

    public function setSleep(string $sleep): static
    {
        $this->sleep = $sleep;

        return $this;
    }

    public function getMorningMood(): ?string
    {
        return $this->morningMood;
    }

    public function setMorningMood(string $morningMood): static
    {
        $this->morningMood = $morningMood;

        return $this;
    }

    public function getDayProgram(): ?string
    {
        return $this->dayProgram;
    }

    public function setDayProgram(?string $dayProgram): static
    {
        $this->dayProgram = $dayProgram;

        return $this;
    }

    public function getDayFeeling(): ?string
    {
        return $this->dayFeeling;
    }

    public function setDayFeeling(?string $dayFeeling): static
    {
        $this->dayFeeling = $dayFeeling;

        return $this;
    }

    public function getFallingAsleep(): ?string
    {
        return $this->fallingAsleep;
    }

    public function setFallingAsleep(?string $fallingAsleep): static
    {
        $this->fallingAsleep = $fallingAsleep;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}

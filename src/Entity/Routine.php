<?php

namespace App\Entity;

use App\Repository\RoutineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoutineRepository::class)]
class Routine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'routines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RoutineContainer $routineContainer = null;

    #[ORM\Column(length: 64)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'routine', targetEntity: RoutineTask::class,  cascade: ['persist', 'remove'])]
    private Collection $routineTasks;

    public function __construct()
    {
        $this->routineTasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoutineContainer(): ?RoutineContainer
    {
        return $this->routineContainer;
    }

    public function setRoutineContainer(?RoutineContainer $routineContainer): static
    {
        $this->routineContainer = $routineContainer;

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

    /**
     * @return Collection<int, RoutineTask>
     */
    public function getRoutineTasks(): Collection
    {
        return $this->routineTasks;
    }

    public function addRoutineTask(RoutineTask $routineTask): static
    {
        if (!$this->routineTasks->contains($routineTask)) {
            $this->routineTasks->add($routineTask);
            $routineTask->setRoutine($this);
        }

        return $this;
    }

    public function removeRoutineTask(RoutineTask $routineTask): static
    {
        if ($this->routineTasks->removeElement($routineTask)) {
            // set the owning side to null (unless already changed)
            if ($routineTask->getRoutine() === $this) {
                $routineTask->setRoutine(null);
            }
        }

        return $this;
    }
}

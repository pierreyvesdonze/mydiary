<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'book', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: BookContent::class, orphanRemoval: true)]
    private Collection $bookContents;

    public function __construct()
    {
        $this->bookContents = new ArrayCollection();
    }

    public function getId()
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

    /**
     * @return Collection<int, BookContent>
     */
    public function getBookContents(): Collection
    {
        return $this->bookContents;
    }

    public function addBookContent(BookContent $bookContent): static
    {
        if (!$this->bookContents->contains($bookContent)) {
            $this->bookContents->add($bookContent);
            $bookContent->setBook($this);
        }

        return $this;
    }

    public function removeBookContent(BookContent $bookContent): static
    {
        if ($this->bookContents->removeElement($bookContent)) {
            // set the owning side to null (unless already changed)
            if ($bookContent->getBook() === $this) {
                $bookContent->setBook(null);
            }
        }

        return $this;
    }
}

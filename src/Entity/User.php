<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Book $book = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Date::class)]
    private Collection $dates;

    #[ORM\Column(length: 64)]
    private ?string $pseudo = null;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: FriendshipRequest::class, fetch: 'EAGER')]
    private Collection $friendshipRequests;

    #[ORM\OneToMany(mappedBy: 'user1', targetEntity: Friendship::class)]
    private Collection $friendships;

    public function __construct()
    {
        $this->dates = new ArrayCollection();
        $this->friendshipRequests = new ArrayCollection();
        $this->friendships = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(Book $book): static
    {
        // set the owning side of the relation if necessary
        if ($book->getUser() !== $this) {
            $book->setUser($this);
        }

        $this->book = $book;

        return $this;
    }

    /**
     * @return Collection<int, Date>
     */
    public function getDates(): Collection
    {
        return $this->dates;
    }

    public function addDate(Date $date): static
    {
        if (!$this->dates->contains($date)) {
            $this->dates->add($date);
            $date->setUser($this);
        }

        return $this;
    }

    public function removeDate(Date $date): static
    {
        if ($this->dates->removeElement($date)) {
            // set the owning side to null (unless already changed)
            if ($date->getUser() === $this) {
                $date->setUser(null);
            }
        }

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection<int, FriendshipRequest>
     */
    public function getFriendshipRequests(): Collection
    {
        return $this->friendshipRequests;
    }

    public function addFriendshipRequest(FriendshipRequest $friendshipRequest): static
    {
        if (!$this->friendshipRequests->contains($friendshipRequest)) {
            $this->friendshipRequests->add($friendshipRequest);
            $friendshipRequest->setSender($this);
        }

        return $this;
    }

    public function removeFriendshipRequest(FriendshipRequest $friendshipRequest): static
    {
        if ($this->friendshipRequests->removeElement($friendshipRequest)) {
            // set the owning side to null (unless already changed)
            if ($friendshipRequest->getSender() === $this) {
                $friendshipRequest->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendships(): Collection
    {
        return $this->friendships;
    }

    public function addFriendship(Friendship $friendship): static
    {
        if (!$this->friendships->contains($friendship)) {
            $this->friendships->add($friendship);
            $friendship->setUser1($this);
        }

        return $this;
    }

    public function removeFriendship(Friendship $friendship): static
    {
        if ($this->friendships->removeElement($friendship)) {
            // set the owning side to null (unless already changed)
            if ($friendship->getUser1() === $this) {
                $friendship->setUser1(null);
            }
        }

        return $this;
    }
}

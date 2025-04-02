<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'user_type', type: 'string')]
#[ORM\DiscriminatorMap([
    'user' => User::class,
    'admin' => Admin::class,
    'student' => Student::class,
    'teacher' => Teacher::class
])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Participation::class, cascade: ['persist', 'remove'])]
    private Collection $participations;

    /**
     * @var Collection<int, DebateMessage>
     */
    #[ORM\OneToMany(targetEntity: DebateMessage::class, mappedBy: 'author')]
    private Collection $debateMessages;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
        $this->debateMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): static
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setUser($this);
        }
        return $this;
    }

    public function removeParticipation(Participation $participation): static
    {
        if ($this->participations->removeElement($participation)) {
            if ($participation->getUser() === $this) {
                $participation->setUser(null);
            }
        }
        return $this;
    }

    public function getRoles(): array
    {
        return match (true) {
            $this instanceof Student => ['ROLE_USER', 'ROLE_STUDENT'],
            $this instanceof Teacher => ['ROLE_USER', 'ROLE_TEACHER'],
            $this instanceof Admin => ['ROLE_USER', 'ROLE_ADMIN'],
            default => ['ROLE_USER'],
        };
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {

    }


    public function getUserType(): string
    {
        return match (true) {
            $this instanceof Student => 'student',
            $this instanceof Teacher => 'teacher',
            $this instanceof Admin => 'admin',
            default => 'user',
        };
    }

    /**
     * @return Collection<int, DebateMessage>
     */
    public function getDebateMessages(): Collection
    {
        return $this->debateMessages;
    }

    public function addDebateMessage(DebateMessage $debateMessage): static
    {
        if (!$this->debateMessages->contains($debateMessage)) {
            $this->debateMessages->add($debateMessage);
            $debateMessage->setAuthor($this);
        }

        return $this;
    }

    public function removeDebateMessage(DebateMessage $debateMessage): static
    {
        if ($this->debateMessages->removeElement($debateMessage)) {
            // set the owning side to null (unless already changed)
            if ($debateMessage->getAuthor() === $this) {
                $debateMessage->setAuthor(null);
            }
        }

        return $this;
    }
}

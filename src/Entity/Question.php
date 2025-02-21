<?php

namespace App\Entity;

use App\Enum\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $texte = null;

    #[ORM\Column(nullable: true, enumType: QuestionType::class)]
    private ?QuestionType $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: UserAnswer::class, cascade: ['persist', 'remove'])]
    private Collection $userAnswers;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): static
    {
        $this->texte = $texte;

        return $this;
    }

    public function getType(): ?QuestionType
    {
        return $this->type;
    }

    public function setType(?QuestionType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}

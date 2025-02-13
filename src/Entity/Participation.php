<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateParticipation = null;

    #[ORM\Column]
    private ?float $score = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $Id): static
    {
        $this->Id = $Id;

        return $this;
    }

    public function getDateParticipation(): ?\DateTimeInterface
    {
        return $this->dateParticipation;
    }

    public function setDateParticipation(\DateTimeInterface $dateParticipation): static
    {
        $this->dateParticipation = $dateParticipation;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): static
    {
        $this->score = $score;

        return $this;
    }
}

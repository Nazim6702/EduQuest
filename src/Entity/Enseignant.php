<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignantRepository::class)]
class Enseignant extends Utilisateur 
{
    #[ORM\OneToMany(mappedBy: "enseignant", targetEntity: Quiz::class, orphanRemoval: true)]
    private Collection $quizzes;

    public function __construct()
    {
        parent::__construct();
        $this->quizzes = new ArrayCollection();
    }

    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes->add($quiz);
            $quiz->setEnseignant($this);
        }
        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->quizzes->removeElement($quiz)) {
            if ($quiz->getEnseignant() === $this) {
                $quiz->setEnseignant(null);
            }
        }
        return $this;
    }
}

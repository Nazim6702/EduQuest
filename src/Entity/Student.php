<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Student extends User
{
    #[ORM\Column(length: 50)]
    private ?string $gradeLevel = null;

    public function getGradeLevel(): ?string
    {
        return $this->gradeLevel;
    }

    public function setGradeLevel(string $gradeLevel): static
    {
        $this->gradeLevel = $gradeLevel;

        return $this;
    }
}

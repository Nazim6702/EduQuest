<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: '`admin`')]
class Admin extends User
{
    #[ORM\Column(type: 'integer')]
    private ?int $adminLevel = null;

    public function getAdminLevel(): ?int
    {
        return $this->adminLevel;
    }

    public function setAdminLevel(int $adminLevel): static
    {
        $this->adminLevel = $adminLevel;

        return $this;
    }
}

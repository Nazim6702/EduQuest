<?php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserEditionService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function updateUser(User $user, ?string $plainPassword = null): void
    {
        if ($plainPassword) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
        }

        $this->em->flush();
    }
}

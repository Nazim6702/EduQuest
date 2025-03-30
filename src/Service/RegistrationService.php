<?php

namespace App\Service;

use App\Entity\Admin;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function registerUser(User $formUser, string $userType, string $plainPassword): User
    {
        $user = match ($userType) {
            'admin' => (new Admin())->setAdminLevel(1),
            'student' => (new Student())->setGradeLevel('Première année'),
            'teacher' => (new Teacher())->setSubject('Non défini'),
            default => $formUser
        };

        if ($user !== $formUser) {
            $user->setName($formUser->getName())
                 ->setEmail($formUser->getEmail())
                 ->setPseudo($formUser->getPseudo());
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
        $user->setCreatedAt(new \DateTime());

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}

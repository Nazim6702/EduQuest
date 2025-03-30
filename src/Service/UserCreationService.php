<?php
namespace App\Service;

use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreationService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function createUser(array $data, string $userType, string $password): object
    {
        $user = match ($userType) {
            'student' => new Student(),
            'teacher' => new Teacher(),
            default => throw new \LogicException('Type d\'utilisateur invalide.')
        };

        $user->setName($data['name'])
             ->setEmail($data['email'])
             ->setPseudo($data['pseudo'])
             ->setCreatedAt(new \DateTime());

        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $password)
        );

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}

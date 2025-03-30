<?php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserDeletionService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function delete(User $user): void
    {
        if ($user instanceof \App\Entity\Admin) {
            throw new AccessDeniedException("Action interdite sur un administrateur.");
        }

        $this->em->remove($user);
        $this->em->flush();
    }
}

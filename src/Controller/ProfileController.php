<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface; // Ajoutez cette ligne
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function profile(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupère l'utilisateur depuis la base de données
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        // Passe l'utilisateur à la template
        return $this->render('profile/profile.html.twig', [
            'user' => $user,
        ]);
    }
}

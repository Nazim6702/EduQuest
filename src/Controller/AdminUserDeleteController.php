<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserDeleteController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/{id}/delete', name: 'admin_user_delete')]
    public function __invoke(User $user, Request $request): Response
    {
        if ($user instanceof \App\Entity\Admin) {
            throw $this->createAccessDeniedException("Action interdite sur un administrateur.");
        }

        if ($request->isMethod('POST')) {
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur supprimé avec succès.');

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/user_confirm_delete.html.twig', [
            'user' => $user
        ]);
    }
}

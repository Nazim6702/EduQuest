<?php
namespace App\Controller;

use App\Entity\User;
use App\Service\UserDeletionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserDeleteController extends AbstractController
{
    #[Route('/{id}/delete', name: 'admin_user_delete')]
    public function __invoke(User $user, Request $request, UserDeletionService $deletion): Response
    {
        if ($request->isMethod('POST')) {
            $deletion->delete($user);
            $this->addFlash('success', 'Utilisateur supprimé avec succès.');
            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/user_confirm_delete.html.twig', ['user' => $user]);
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminEditUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    #[Route('/', name: 'admin_user_list')]
    public function list(Request $request): Response
    {
        $search = $request->query->get('search');
        $qb = $this->em->getRepository(User::class)->createQueryBuilder('u')
        ->where('u NOT INSTANCE OF App\\Entity\\Admin');

        if ($search) {
            $qb->andWhere('u.name LIKE :s OR u.pseudo LIKE :s OR u.email LIKE :s')
               ->setParameter('s', "%$search%");
        }

        return $this->render('admin/user_list.html.twig', [
            'users' => $qb->getQuery()->getResult(),
            'search' => $search
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_user_edit')]
    public function edit(User $user, Request $request): Response
    {
        $this->denyIfAdmin($user);

        $form = $this->createForm(AdminEditUserFormType::class, $user)
                     ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($pass = $form->get('password')->getData()) {
                $user->setPassword($this->passwordHasher->hashPassword($user, $pass));
            }
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur modifié avec succès !');
            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/user_edit.html.twig', [
            'form' => $form->createView(), 'user' => $user
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_user_delete')]
    public function delete(User $user, Request $request): Response
    {
        $this->denyIfAdmin($user);

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

    private function denyIfAdmin(User $user): void
    {
        if ($user->getUserType() === 'admin') {
            throw $this->createAccessDeniedException("Action interdite sur un administrateur.");
        }
    }
}

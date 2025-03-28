<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminEditUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserEditController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface      $em,
        private UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    #[Route('/{id}/edit', name: 'admin_user_edit')]
    public function __invoke(User $user, Request $request): Response
    {
        if ($user instanceof \App\Entity\Admin) {
            throw $this->createAccessDeniedException("Action interdite sur un administrateur.");
        }

        $form = $this->createForm(AdminEditUserFormType::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($pass = $form->get('password')->getData()) {
                $user->setPassword($this->passwordHasher->hashPassword($user, $pass));
            }

            $this->em->flush();
            $this->addFlash('success', 'Utilisateur modifié avec succès !');

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/user_edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}

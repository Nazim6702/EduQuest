<?php

namespace App\Controller;

use App\Form\EditProfileFormType;
use App\Service\ProfileEditService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileEditController extends AbstractController
{
    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function __invoke(Request $request, UserInterface $user, ProfileEditService $service): Response
    {
        $form = $this->createForm(EditProfileFormType::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->updateUser($user, $form);
            $this->addFlash('success', 'Profil mis à jour avec succès !');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit.html.twig', ['form' => $form->createView()]);
    }
}

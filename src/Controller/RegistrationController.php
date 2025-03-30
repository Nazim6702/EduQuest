<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, RegistrationService $registration): Response
    {
        $formUser = new User();
        $form = $this->createForm(RegistrationFormType::class, $formUser)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registration->registerUser($formUser, $form->get('userType')->getData(), $form->get('password')->getData());
            return $this->redirectToRoute('app_login');
        }

        return $this->render('auth/register.html.twig', ['form' => $form->createView()]);
    }
}

<?php
namespace App\Controller;

use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function __invoke(AuthenticationUtils $authUtils): Response
    {
        $form = $this->createForm(LoginFormType::class, [
            'email' => $authUtils->getLastUsername(),
        ]);

        return $this->render('auth/login.html.twig', [
            'form' => $form->createView(),
            'error' => $authUtils->getLastAuthenticationError(),
        ]);
    }
}

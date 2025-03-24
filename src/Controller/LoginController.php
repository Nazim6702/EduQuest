<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\Admin;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user && $passwordEncoder->isPasswordValid($user, $password)) {
                // Rediriger vers la page de profil
                return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
            }

            $this->addFlash('error', 'Email ou mot de passe incorrect.');
        }

        return $this->render('security/login.html.twig');
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $role = $request->request->get('role');
            $user = null;
    
            switch ($role) {
                case 'student':
                    $user = new Student();
                    break;
                case 'professor':
                    $user = new Teacher();
                    break;
                case 'admin':
                    $user = new Admin();
                    break;
                default:
                    $this->addFlash('error', 'Rôle invalide.');
                    return $this->redirectToRoute('app_register');
            }
    
            $user->setName($request->request->get('username'));
            $user->setEmail($request->request->get('email'));
            $user->setPassword($passwordHasher->hashPassword($user, $request->request->get('password')));
    
            $entityManager->persist($user);
            $entityManager->flush();
    
            $this->addFlash('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');
            return $this->redirectToRoute('app_login');
        }
    
        return $this->render('security/register.html.twig');
    }
}

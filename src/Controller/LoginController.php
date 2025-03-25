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
    private $entityManager;

    // Injection de l'EntityManager via le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
    
            // Récupère l'utilisateur depuis la base de données
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    
            // Vérifie si l'utilisateur existe et si le mot de passe est valide
            if ($user && $passwordHasher->isPasswordValid($user, $password)) {
                // Redirige vers la page de profil
                return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
            } else {
                // Ajoute un message flash en cas d'échec
                $this->addFlash('error', 'Email ou mot de passe incorrect.');
            }
    
            // Redirige vers la page de connexion pour afficher le message flash
            return $this->redirectToRoute('app_login');
        }
    
        // Affiche la page de connexion
        return $this->render('security/login.html.twig');
    }
    

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($request->isMethod('POST')) {
            $role = $request->request->get('role');
            $username = $request->request->get('username');
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Vérification des données du formulaire
            if (!$username || !$email || !$password || !$role) {
                $this->addFlash('error', 'Tous les champs sont obligatoires.');
                return $this->redirectToRoute('app_register');
            }

            // Crée l'utilisateur en fonction du rôle sélectionné
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

            // Définit les propriétés de l'utilisateur
            $user->setName($username);
            $user->setEmail($email);
            $user->setPassword($passwordHasher->hashPassword($user, $password));

            // Sauvegarde l'utilisateur dans la base de données
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig');
    }
}

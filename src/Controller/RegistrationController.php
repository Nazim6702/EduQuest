<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $formUser = new User();
        $form = $this->createForm(RegistrationFormType::class, $formUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userType = $form->get('userType')->getData();
            
            $user = match ($userType) {
                'admin' => (new Admin())->setAdminLevel(1),
                'student' => (new Student())->setGradeLevel('Première année'),
                'teacher' => (new Teacher())->setSubject('Non défini'),
                default => $formUser
            };
            
            if ($user !== $formUser) {
                $user->setName($formUser->getName())
                     ->setEmail($formUser->getEmail())
                     ->setPseudo($formUser->getPseudo());
            }
            
            $user->setPassword($passwordHasher->hashPassword($user, $form->get('password')->getData()))
                 ->setCreatedAt(new \DateTime());
                
            $entityManager->persist($user);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
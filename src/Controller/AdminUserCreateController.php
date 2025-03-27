<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Teacher;
use App\Form\AdminCreateUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserCreateController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    #[Route('/create', name: 'admin_user_create')]
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(AdminCreateUserFormType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $userType = $form->get('userType')->getData();
            $password = $form->get('password')->getData();

            $user = match ($userType) {
                'student' => new Student(),
                'teacher' => new Teacher(),
                default   => throw new \LogicException('Type d\'utilisateur invalide.')
            };

            $user->setName($data['name'])
                ->setEmail($data['email'])
                ->setPseudo($data['pseudo'])
                ->setCreatedAt(new \DateTime());

            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Nouvel utilisateur créé avec succès.');
            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/user_create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

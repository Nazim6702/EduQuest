<?php

namespace App\Controller;

use App\Entity\Participation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgressionController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/progression', name: 'app_progression')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        // Utilisation de l'EntityManager pour récupérer les participations de l'étudiant
        $participations = $this->em->getRepository(Participation::class)->findBy(['user' => $user]);

        return $this->render('progression/index.html.twig', [
            'participations' => $participations,
        ]);
    }
}

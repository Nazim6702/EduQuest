<?php

namespace App\Controller;

use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AvisController extends AbstractController
{
    #[Route('/laisser-un-avis', name: 'app_avis')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        // Récupération des avis triés par date (du plus récent au plus ancien)
        $avisRepository = $em->getRepository(Avis::class);
        $avisList = $avisRepository->findBy([], ['createdAt' => 'DESC']); 
        
        // Ajout du dump pour vérifier si la variable $avisList contient bien des avis
        dump($avisList);  // Cela va afficher la liste des avis dans la console ou dans le navigateur (mode dev)

        // Création du formulaire
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('rating', ChoiceType::class, [
                'label' => 'Note',
                'choices' => [
                    '1 - Très mauvais' => 1,
                    '2 - Mauvais' => 2,
                    '3 - Moyenne' => 3,
                    '4 - Bon' => 4,
                    '5 - Excellent' => 5,
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Commentaire',
                'attr' => ['rows' => 5],
            ])
            ->getForm();

        // Traitement du formulaire
        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();  // Récupère les données du formulaire
            
            // Ajout du dump pour vérifier les données récupérées depuis le formulaire
            dump($data);  // Cela va afficher les données soumises par l'utilisateur

            // Création d'un nouvel objet Avis
            $avis = new Avis();
            $avis->setName($data['name']);
            $avis->setEmail($data['email']);
            $avis->setRating($data['rating']);
            $avis->setMessage($data['message']);
            $avis->setCreatedAt(new \DateTime());  // Enregistrement de la date actuelle

            // Sauvegarde l'avis dans la base de données
            $em->persist($avis);
            $em->flush();

            // Redirige vers la même page après la soumission du formulaire
            return $this->redirectToRoute('app_avis');
        }

        // Rendu de la vue avec le formulaire et les avis existants
        return $this->render('link_footer/avis.html.twig', [
            'form' => $form->createView(),
            'messages' => $avisList  // Envoie les avis récupérés à la vue
        ]);
    }
}

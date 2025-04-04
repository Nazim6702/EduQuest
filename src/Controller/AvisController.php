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
      
        $avisRepository = $em->getRepository(Avis::class);
        $avisList = $avisRepository->findBy([], ['createdAt' => 'DESC']); 
        
        
        dump($avisList);  

       
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

        
        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $data = $form->getData(); 
            
            dump($data);  
            $avis = new Avis();
            $avis->setName($data['name']);
            $avis->setEmail($data['email']);
            $avis->setRating($data['rating']);
            $avis->setMessage($data['message']);
            $avis->setCreatedAt(new \DateTime());  

            $em->persist($avis);
            $em->flush();

            return $this->redirectToRoute('app_avis');
        }

        return $this->render('link_footer/avis.html.twig', [
            'form' => $form->createView(),
            'messages' => $avisList  
        ]);
    }
}

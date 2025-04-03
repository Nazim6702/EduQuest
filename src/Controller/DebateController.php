<?php

namespace App\Controller;

use App\Entity\DebateMessage;
use App\Form\DebateMessageType;
use App\Repository\DebateMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DebateController extends AbstractController
{
    #[Route('/debat', name: 'app_debate')]
    public function index(Request $request, EntityManagerInterface $em, DebateMessageRepository $repo): Response
    {
        $message = new DebateMessage();
        
       
        $replyToId = $request->query->get('replyTo');
        if ($replyToId) {
            $parent = $repo->find($replyToId);
            if ($parent) {
                $message->setParent($parent);
            }
        }
    
        $form = $this->createForm(DebateMessageType::class, $message);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setAuthor($this->getUser());
            $message->setCreatedAt(new \DateTimeImmutable());
            $message->setLikes(0);
            $em->persist($message);
            $em->flush();
    
            return $this->redirectToRoute('app_debate');
        }
    
        $messages = $repo->findBy(['parent' => null], ['createdAt' => 'DESC']);
    
        return $this->render('debate/index.html.twig', [
            'form' => $form->createView(),
            'messages' => $messages
        ]);
    }
    

    #[Route('/debat/like/{id}', name: 'app_debate_like')]
public function like(DebateMessage $message, EntityManagerInterface $em): Response
{
    $message->like();
    $em->flush();

    return $this->redirectToRoute('app_debate');
}

}

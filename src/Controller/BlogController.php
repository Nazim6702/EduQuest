<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        $articles = [
            ['titre' => 'Pourquoi apprendre avec des quiz ?', 'date' => '2025-04-01', 'auteur' => 'Jean Dupont', 'contenu' => 'Les quiz sont un excellent moyen d\'apprendre tout en s\'amusant...'],
            ['titre' => 'Les meilleures astuces pour réussir vos quiz', 'date' => '2025-03-28', 'auteur' => 'Marie Durand', 'contenu' => 'Dans cet article, nous partageons des conseils pratiques pour améliorer vos scores...'],
            ['titre' => 'Les nouveautés à venir sur EduQuest', 'date' => '2025-03-15', 'auteur' => 'Luc Martin', 'contenu' => 'Nous avons quelques grandes mises à jour qui arrivent pour améliorer votre expérience...'],
        ];

        return $this->render('link_footer/blog.html.twig', [
            'articles' => $articles,
        ]);
    }
}

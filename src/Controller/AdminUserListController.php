<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserListController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/', name: 'admin_user_list')]
    public function __invoke(Request $request): Response
    {
        $search = $request->query->get('search');
        $qb = $this->em->getRepository(User::class)->createQueryBuilder('u')
            ->where('u NOT INSTANCE OF App\\Entity\\Admin');

        if ($search) {
            $qb->andWhere('u.name LIKE :s OR u.pseudo LIKE :s OR u.email LIKE :s')
                ->setParameter('s', "%$search%");
        }

        return $this->render('admin/user_list.html.twig', [
            'users' => $qb->getQuery()->getResult(),
            'search' => $search
        ]);
    }
}

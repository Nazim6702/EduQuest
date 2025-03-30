<?php
namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserListController extends AbstractController
{
    #[Route('/', name: 'admin_user_list')]
    public function __invoke(Request $request, UserRepository $userRepository): Response
    {
        $search = $request->query->get('search');
        $users = $userRepository->findAllExceptAdmins($search);

        return $this->render('admin/user_list.html.twig', [
            'users' => $users,
            'search' => $search,
        ]);
    }
}

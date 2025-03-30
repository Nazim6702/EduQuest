<?php
namespace App\Controller;

use App\Form\AdminCreateUserFormType;
use App\Service\UserCreationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserCreateController extends AbstractController
{
    #[Route('/create', name: 'admin_user_create')]
    public function __invoke(Request $request, UserCreationService $creator): Response
    {
        $form = $this->createForm(AdminCreateUserFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $creator->createUser($data, $form->get('userType')->getData(), $form->get('password')->getData());
            $this->addFlash('success', 'Nouvel utilisateur créé avec succès.');
            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/user_create.html.twig', ['form' => $form->createView()]);
    }
}

<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(private RouterInterface $router) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $user = $token->getUser();

        return match ($user->getUserType()) {
            'student' => new RedirectResponse($this->router->generate('app_profile_student')),
            'teacher' => new RedirectResponse($this->router->generate('app_profile_teacher')),
            'admin' => new RedirectResponse($this->router->generate('app_profile_admin')),
            default => new RedirectResponse($this->router->generate('app_home')),
        };
    }
}


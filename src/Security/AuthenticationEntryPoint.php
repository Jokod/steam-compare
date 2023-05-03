<?php

namespace App\Security;

use App\Service\UserContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private UserContext $userContext
    ) {
    }

    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        $this->userContext->reset();

        return new RedirectResponse($this->urlGenerator->generate('login'));
    }
}

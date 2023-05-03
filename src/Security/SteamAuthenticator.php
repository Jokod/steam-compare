<?php

namespace App\Security;

use App\Repository\UserRepository;
use App\Service\SteamClient;
use App\Service\UserContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class SteamAuthenticator extends AbstractAuthenticator
{
    private string $credentials;

    public function __construct(
        private SteamClient $steamClient,
        private RouterInterface $router,
        private UserRepository $userRepository,
        private UserContext $userContext
    ) {
    }

    public function start(): Response
    {
        return new Response('', Response::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request): ?bool
    {
        return 'oauth_check' === $request->attributes->get('_route') && $request->query->has('credential');
    }

    public function authenticate(Request $request): Passport
    {
        $this->credentials = $request->query->get('credential');

        $badge = new UserBadge('steamId', function () {
            return $this->userRepository->findOrCreateUser($this->credentials);
        });

        return new SelfValidatingPassport($badge);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('dashboard'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new RedirectResponse($this->router->generate('login'));
    }
}

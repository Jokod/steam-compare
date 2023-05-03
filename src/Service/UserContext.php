<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class UserContext
{
    private SessionInterface $session;

    public function __construct(
        private RequestStack $requestStack,
        private Security $security,
        private UserRepository $userRepository,
        private UrlGeneratorInterface $urlGenerator
    ) {
        $this->session = $this->requestStack->getSession();
    }

    public function getUser(): ?User
    {
        return $this->security->getUser();
    }

    public function isAuthenticated(): bool
    {
        return null !== $this->getUser();
    }

    public function setUserJWT(?string $jwt): void
    {
        $this->session->set('_gta', $jwt);
    }

    public function getUserJWT(): ?string
    {
        return $this->session->get('_gta');
    }

    public function resetUserJWT(): void
    {
        $this->session->set('_gta', null);
    }

    public function setUserAccessToken(?string $accessToken): void
    {
        $this->session->set('_at', $accessToken);
    }

    public function getUserAccessToken(): ?string
    {
        return $this->session->get('_at');
    }

    public function resetUserAccessToken(): void
    {
        $this->session->set('_at', null);
    }

    public function setUserRefreshToken(?string $refreshToken): void
    {
        $this->userRepository->updateRefreshToken($this->getUser(), $refreshToken);
    }

    public function getUserRefreshToken(): ?string
    {
        if (!$this->isAuthenticated()) {
            return null;
        }

        return $this->userRepository->getRefreshToken($this->getUser());
    }

    public function reset(): void
    {
        $this->resetUserAccessToken();
        $this->resetUserJWT();
    }
}

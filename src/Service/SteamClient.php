<?php

namespace App\Service;

use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SteamClient
{
    public const STEAMAPI_BASE  = 'https://api.steampowered.com';
    public const COMMUNITY_BASE = 'https://steamcommunity.com';
    public const STORE_BASE     = 'https://store.steampowered.com';
    public const OPENID_BASE    = 'https://steamcommunity.com/openid';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private UserRepository $userRepository,
        private UserContext $userContext,
        private LoggerInterface $logger,
        private TokenStorageInterface $tokenStorage,
    ) {
    }

    /**
     * Renvoie le client Steam.
     */
    // public function getClient(): Client
    // {
    //     return $this->client;
    // }
}

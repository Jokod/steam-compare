<?php

namespace App\Service;

use App\Entity\SteamClient\SteamUser;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SteamClient
{
    public const STEAMAPI_BASE  = 'https://api.steampowered.com';
    public const COMMUNITY_BASE = 'https://steamcommunity.com';
    public const STORE_BASE     = 'https://store.steampowered.com';
    public const OPENID_BASE    = 'https://steamcommunity.com/openid';

    public function __construct(
        private string $apiKey,
        private HttpClientInterface $httpClient,
        private UrlGeneratorInterface $urlGenerator,
        private UserRepository $userRepository,
        private UserContext $userContext,
        private LoggerInterface $logger,
        private TokenStorageInterface $tokenStorage
    ) {
    }

    /**
     * Renvoie les information de l'utilisateur.
     *
     * @return SteamUser[] $users
     */
    public function getUserInfo(array|string $steamIds): array
    {
        if (\is_array($steamIds)) {
            $steamIds = implode(',', $steamIds);
        }

        try {
            $url      = self::STEAMAPI_BASE . '/ISteamUser/GetPlayerSummaries/v2/?key=' . $this->apiKey . '&steamids=' . $steamIds;
            $response = $this->request($url);

            $users = [];
            foreach ($response['response']['players'] as $userInfos) {
                $steamUser = new SteamUser();
                $steamUser->setSteamId($userInfos['steamid']);
                $steamUser->setCommunityVisibilityState($userInfos['communityvisibilitystate']);
                $steamUser->setProfileState($userInfos['profilestate']);
                $steamUser->setPersonaState($userInfos['personastate']);
                $steamUser->setPersonaName($userInfos['personaname']);
                $steamUser->setLastLogoff($userInfos['lastlogoff']);
                $steamUser->setProfileUrl($userInfos['profileurl']);
                $steamUser->setAvatar($userInfos['avatar']);
                $steamUser->setAvatarMedium($userInfos['avatarmedium']);
                $steamUser->setAvatarFull($userInfos['avatarfull']);
                $steamUser->setPersonaState($userInfos['personastate']);
                $steamUser->setPrimaryClanId($userInfos['primaryclanid']);
                $steamUser->setTimeCreated($userInfos['timecreated']);
                $steamUser->setPersonaStateFlags($userInfos['personastateflags']);

                $users[] = $steamUser;
            }

            return $users;
        } catch (\Exception $e) {
            throw new \Exception('Impossible de récupérer les informations du/des joueur(s).');
        }
    }

    /**
     * Renvoie les jeux de l'utilisateur.
     */
    public function getUserGames(string $steamId, bool $free, bool $infos): null|array
    {
        try {
            $url = self::STEAMAPI_BASE . '/IPlayerService/GetOwnedGames/v1/?key=' . $this->apiKey . '&steamid=' . $steamId . '&include_played_free_games=' . (int) $free . '&include_appinfo=' . (int) $infos;

            return $this->request($url);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Renvoie les amis de l'utilisateur.
     */
    public function getUserFriends(string $steamId): null|array
    {
        try {
            $url = self::STEAMAPI_BASE . '/ISteamUser/GetFriendList/v1/?key=' . $this->apiKey . '&steamid=' . $steamId . '&relationship=friend';

            return $this->request($url);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Renvoie les groupes de l'utilisateur.
     */
    public function getUserGroups(string $steamId): null|array
    {
        try {
            $url = self::STEAMAPI_BASE . '/ISteamUser/GetUserGroupList/v1/?key=' . $this->apiKey . '&steamid=' . $steamId;

            return $this->request($url);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Renvoie les informations d'un jeu.
     */
    public function getGameInfo(string $appId): array
    {
        $url = self::STORE_BASE . '/api/appdetails?appids=' . $appId;

        return $this->request($url);
    }

    /**
     * Renvoie les informations d'un groupe.
     */
    public function getGroupInfo(string $groupId): array
    {
        $url = self::STEAMAPI_BASE . '/ISteamUser/GetUserGroupList/v1/?key=' . $this->apiKey . '&groupid=' . $groupId;

        return $this->request($url);
    }

    /**
     * Renvoie les informations d'un utilisateur.
     */
    public function request(string $url): array
    {
        $response = $this->httpClient->request('GET', $url);

        return json_decode($response->getContent(), true);
    }
}

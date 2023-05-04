<?php

namespace App\Controller;

use App\Service\SteamClient;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class ComparatorController extends BaseController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    #[Route('/user/load/{steamId}', name: 'user_load', options: ['expose' => true])]
    public function index(SteamClient $steamClient, int $steamId): JsonResponse
    {
        try {
            $userInfos   = $steamClient->getUserInfo($steamId)[0];
            $userFriends = $steamClient->getUserFriends($steamId)['friendslist']['friends'] ?? null;

            if ($userFriends) {
                $userFriendsSteamIds = array_column($userFriends, 'steamid');
                $userFriends         = $steamClient->getUserInfo($userFriendsSteamIds);
            }

            if ($userFriends) {
                usort($userFriends, function ($a, $b) {
                    return $a->getPersonaName() <=> $b->getPersonaName();
                });

                $userFriends = \array_slice($userFriends, 0, 100);
            }

            return $this->json([
                'infos'   => $userInfos,
                'friends' => $userFriends,
            ]);
        } catch (\Exception $e) {
            return $this->json(['code' => 'error', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/player/games/{steamId}', name: 'player_games', options: ['expose' => true])]
    public function playerGames(Request $request, SteamClient $steamClient, int $steamId): JsonResponse
    {
        try {
            $datas = json_decode($request->getContent(), true);

            $userGames = $steamClient->getUserGames($steamId, $datas['free'], $datas['appInfos']);

            return $this->json($userGames['response']['games']);
        } catch (\Exception $e) {
            return $this->json(['code' => 'error', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('game/infos/{appId}', name: 'game_infos', options: ['expose' => true])]
    public function appInfos(SteamClient $steamClient, int $appId): JsonResponse
    {
        try {
            if (!$appId) {
                throw new \Exception('Aucun jeu trouvé');
            }

            $appInfos = $steamClient->getGameInfo($appId)[$appId]['data'];

            return $this->json($appInfos);
        } catch (\Exception $e) {
            return $this->json(['code' => 'error', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('games/infos', name: 'games_infos', options: ['expose' => true])]
    public function gamesInfos(Request $request, SteamClient $steamClient): JsonResponse
    {
        try {
            $appsIds = json_decode($request->getContent(), true) ?? null;

            if (!$appsIds) {
                throw new \Exception('Aucun jeu trouvé');
            }

            $games = [];
            foreach ($appsIds as $appId) {
                $games[$appId] = $steamClient->getGameInfo($appId)[$appId]['data'];
            }

            return $this->json($games);
        } catch (\Exception $e) {
            return $this->json(['code' => 'error', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}

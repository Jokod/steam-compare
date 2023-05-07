<?php

namespace App\Controller;

use App\Exception\InvalidArgumentException;
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
                usort($userFriends, fn ($a, $b) => $a->getPersonaName() <=> $b->getPersonaName());
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
            $datas    = json_decode($request->getContent(), true);
            $free     = $datas['free']     ?? true;
            $appInfos = $datas['appInfos'] ?? false;

            $userGames = $steamClient->getUserGames($steamId, $free, $appInfos);

            return $this->json($userGames['response']['games']);
        } catch (\Exception $e) {
            return $this->json(['code' => 'error', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('game/infos/{appId}', name: 'game_infos', options: ['expose' => true])]
    public function appInfos(SteamClient $steamClient, int $appId): JsonResponse
    {
        if (empty($appId)) {
            throw new InvalidArgumentException('L\'identifiant du jeu est manquant.');
        }

        $game = $steamClient->getGameInfo($appId)[$appId];

        $responseCode = Response::HTTP_OK;

        if ($game['success']) {
            $game = $game['data'];
        } else {
            $game         = ['code' => 'error', 'message' => 'Le jeu n\'a pas été trouvé.'];
            $responseCode = Response::HTTP_NOT_FOUND;
        }

        return $this->json($game, $responseCode);
    }

    #[Route('games/infos', name: 'games_infos', options: ['expose' => true])]
    public function gamesInfos(Request $request, SteamClient $steamClient): JsonResponse
    {
        $datas    = json_decode($request->getContent(), true);
        $appsIds  = $datas['appsIds']  ?? null;
        $gamesIds = $datas['gamesIds'] ?? null;

        if (!$appsIds) {
            return $this->json(['code' => 'error', 'message' => 'Aucun jeu trouvé'], Response::HTTP_BAD_REQUEST);
        }

        $games = [];
        foreach (array_diff($appsIds, $gamesIds ?? []) as $appId) {
            $game = $steamClient->getGameInfo($appId)[$appId] ?? null;

            if ($game && $game['success']) {
                $games[$appId] = $game['data'];
            }
        }

        return $this->json($games);
    }
}

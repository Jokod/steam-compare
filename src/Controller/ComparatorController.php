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
    public function index(Request $request, SteamClient $steamClient, int $steamId): JsonResponse
    {
        try {
            $datas = json_decode($request->getContent(), true);

            $userInfos   = $steamClient->getUserInfo($steamId)[0];
            $userGames   = $steamClient->getUserGames($steamId, $datas['free'], $datas['appInfos']);
            $userFriends = $steamClient->getUserFriends($steamId)['friendslist']['friends'] ?? null;

            if ($userFriends) {
                $userFriendsSteamIds = array_column($userFriends, 'steamid');
                $userFriends         = $steamClient->getUserInfo($userFriendsSteamIds);
            }

            usort($userFriends, function ($a, $b) {
                return strcmp($a->getPersonaName(), $b->getPersonaName());
            });

            $userFriends = \array_slice($userFriends, 0, 100);

            return $this->json([
                'infos'      => $userInfos,
                'friends'    => $userFriends,
                'game_count' => $userGames['response']['game_count'],
                'games'      => $userGames['response']['games'],
            ]);
        } catch (\Exception $e) {
            return $this->json(['code' => 'error', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}

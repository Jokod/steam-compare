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

    #[Route('/user/load/{steamId}', name: 'user_load')]
    public function index(Request $request, SteamClient $steamClient, int $steamId): JsonResponse
    {
        try {
            $datas = json_decode($request->getContent(), true);

            return $this->json([
                'userInfos' => $steamClient->getUserInfo($steamId),
                'userGames' => $steamClient->getUserGames($steamId, $datas->free, $datas->appInfos),
            ]);
        } catch (\Exception $e) {
            return $this->json(['code' => 'error', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}

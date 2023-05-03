<?php

namespace App\Controller;

use App\Service\LightOpenID;
use App\Service\SteamClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SteamAuthController extends BaseController
{
    #[Route(path: '/oauth/steam', name: 'oauth_steam_check')]
    public function oauthCheck(Request $request, SteamClient $steamClient): RedirectResponse
    {
        $openid = new LightOpenID($request->getHost());

        if (!$openid->mode) {
            $openid->identity = SteamClient::OPENID_BASE;

            return $this->redirect($openid->authUrl());
        }

        if ('cancel' === $openid->mode) {
            $this->addFlash('error', 'Vous avez annulé la connexion avec Steam.');

            return $this->redirectToRoute('login');
        }

        if ($openid->validate()) {
            $identity = $openid->identity;
            preg_match("/^https:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/", $identity, $matches);
            $steamId = $matches[1];

            return $this->redirectToRoute('oauth_check', ['credential' => $steamId]);
        }

        $this->addFlash('error', 'La connexion avec Steam a échoué.');

        return $this->redirectToRoute('login');
    }
}

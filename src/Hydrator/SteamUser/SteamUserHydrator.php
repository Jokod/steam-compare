<?php

namespace App\Hydrator\SteamUser;

use App\Entity\SteamClient\SteamUser as SteamClientUser;
use App\Entity\User;
use App\Hydrator\AbstractHydrator;

class SteamUserHydrator extends AbstractHydrator
{
    public function hydrate($result): User
    {
        /** @var SteamClientUser $result */
        $steamUser = new User();
        $steamUser->setSteamId($result->getSteamId());
        $steamUser->setCommunityVisibilityState($result->getCommunityVisibilityState());
        $steamUser->setProfileState($result->getProfileState());
        $steamUser->setPersonaName($result->getPersonaName());
        $steamUser->setLastLogoff($result->getLastLogoff());
        $steamUser->setProfileUrl($result->getProfileUrl());
        $steamUser->setAvatar($result->getAvatar());
        $steamUser->setAvatarMedium($result->getAvatarMedium());
        $steamUser->setAvatarFull($result->getAvatarFull());
        $steamUser->setPersonaState($result->getPersonaState());
        $steamUser->setPrimaryClanId($result->getPrimaryClanId());
        $steamUser->setTimeCreated($result->getTimeCreated());
        $steamUser->setPersonaStateFlags($result->getPersonaStateFlags());
        $steamUser->setPassword('');
        $steamUser->setCreatedAt(new \DateTimeImmutable());

        return $steamUser;
    }

    public function supports($result): bool
    {
        return $result instanceof SteamClientUser;
    }
}

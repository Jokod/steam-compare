<?php

namespace App\Entity\SteamClient;

class SteamUser
{
    private $steamId;

    private $communityVisibilityState;

    private $profileState;

    private $personaName;

    private $lastLogoff;

    private $profileUrl;

    private $avatar;

    private $avatarMedium;

    private $avatarFull;

    private $personaState;

    private $primaryClanId;

    private $timeCreated;

    private $personaStateFlags;

    public function getSteamId(): ?string
    {
        return $this->steamId;
    }

    public function setSteamId(string $steamId): self
    {
        $this->steamId = $steamId;

        return $this;
    }

    public function getCommunityVisibilityState(): ?int
    {
        return $this->communityVisibilityState;
    }

    public function setCommunityVisibilityState(int $communityVisibilityState): self
    {
        $this->communityVisibilityState = $communityVisibilityState;

        return $this;
    }

    public function getProfileState(): ?int
    {
        return $this->profileState;
    }

    public function setProfileState(?int $profileState): self
    {
        $this->profileState = $profileState;

        return $this;
    }

    public function getPersonaName(): ?string
    {
        return $this->personaName;
    }

    public function setPersonaName(string $personaName): self
    {
        $this->personaName = $personaName;

        return $this;
    }

    public function getLastLogoff(): ?int
    {
        return $this->lastLogoff;
    }

    public function setLastLogoff(int $lastLogoff): self
    {
        $this->lastLogoff = $lastLogoff;

        return $this;
    }

    public function getProfileUrl(): ?string
    {
        return $this->profileUrl;
    }

    public function setProfileUrl(string $profileUrl): self
    {
        $this->profileUrl = $profileUrl;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAvatarMedium(): ?string
    {
        return $this->avatarMedium;
    }

    public function setAvatarMedium(string $avatarMedium): self
    {
        $this->avatarMedium = $avatarMedium;

        return $this;
    }

    public function getAvatarFull(): ?string
    {
        return $this->avatarFull;
    }

    public function setAvatarFull(string $avatarFull): self
    {
        $this->avatarFull = $avatarFull;

        return $this;
    }

    public function getPersonaState(): ?int
    {
        return $this->personaState;
    }

    public function setPersonaState(int $personaState): self
    {
        $this->personaState = $personaState;

        return $this;
    }

    public function getPrimaryClanId(): ?string
    {
        return $this->primaryClanId;
    }

    public function setPrimaryClanId(string $primaryClanId): self
    {
        $this->primaryClanId = $primaryClanId;

        return $this;
    }

    public function getTimeCreated(): ?int
    {
        return $this->timeCreated;
    }

    public function setTimeCreated(int $timeCreated): self
    {
        $this->timeCreated = $timeCreated;

        return $this;
    }

    public function getPersonaStateFlags(): ?int
    {
        return $this->personaStateFlags;
    }

    public function setPersonaStateFlags(int $personaStateFlags): self
    {
        $this->personaStateFlags = $personaStateFlags;

        return $this;
    }
}

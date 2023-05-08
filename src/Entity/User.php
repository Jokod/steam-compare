<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: 'App\Repository\UserRepository')]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: 'integer', length: 64)]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $steamId;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $communityVisibilityState;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $profileState;

    #[ORM\Column(type: 'string')]
    private $personaName;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $lastLogoff;

    #[ORM\Column(type: 'string', nullable: true)]
    private $profileUrl;

    #[ORM\Column(type: 'string')]
    private $avatar;

    #[ORM\Column(type: 'string')]
    private $avatarMedium;

    #[ORM\Column(type: 'string')]
    private $avatarFull;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $personaState;

    #[ORM\Column(type: 'string', nullable: true)]
    private $primaryClanId;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $timeCreated;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $personaStateFlags;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setSteamId(string $steamId): self
    {
        $this->steamId = $steamId;

        return $this;
    }

    public function getSteamId(): string
    {
        return (string) $this->steamId;
    }

    public function getUsername(): string
    {
        return $this->getPersonaName();
    }

    public function getUserIdentifier()
    {
        return $this->getPersonaName();
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCommunityVisibilityState(): ?int
    {
        return $this->communityVisibilityState;
    }

    public function setCommunityVisibilityState(?int $communityVisibilityState): self
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

    public function getPersonaName(): string
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

    public function setLastLogoff(?int $lastLogoff): self
    {
        $this->lastLogoff = $lastLogoff;

        return $this;
    }

    public function getProfileUrl(): ?string
    {
        return $this->profileUrl;
    }

    public function setProfileUrl(?string $profileUrl): self
    {
        $this->profileUrl = $profileUrl;

        return $this;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAvatarMedium(): string
    {
        return $this->avatarMedium;
    }

    public function setAvatarMedium(string $avatarMedium): self
    {
        $this->avatarMedium = $avatarMedium;

        return $this;
    }

    public function getAvatarFull(): string
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

    public function setPersonaState(?int $personaState): self
    {
        $this->personaState = $personaState;

        return $this;
    }

    public function getPrimaryClanId(): ?string
    {
        return $this->primaryClanId;
    }

    public function setPrimaryClanId(?string $primaryClanId): self
    {
        $this->primaryClanId = $primaryClanId;

        return $this;
    }

    public function getTimeCreated(): ?int
    {
        return $this->timeCreated;
    }

    public function setTimeCreated(?int $timeCreated): self
    {
        $this->timeCreated = $timeCreated;

        return $this;
    }

    public function getPersonaStateFlags(): ?int
    {
        return $this->personaStateFlags;
    }

    public function setPersonaStateFlags(?int $personaStateFlags): self
    {
        $this->personaStateFlags = $personaStateFlags;

        return $this;
    }
}

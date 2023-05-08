<?php

namespace App\Repository;

use App\Entity\SteamClient\SteamUser;
use App\Entity\User;
use App\Hydrator\HydratorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private HydratorInterface $hydrator)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function updateBySteamUser(SteamUser $steamUser, User $user)
    {
        $user->setCommunityVisibilityState($steamUser->getCommunityVisibilityState());
        $user->setProfileState($steamUser->getProfileState());
        $user->setPersonaName($steamUser->getPersonaName());
        $user->setLastLogoff($steamUser->getLastLogoff());
        $user->setProfileUrl($steamUser->getProfileUrl());
        $user->setAvatar($steamUser->getAvatar());
        $user->setAvatarMedium($steamUser->getAvatarMedium());
        $user->setAvatarFull($steamUser->getAvatarFull());
        $user->setPersonaState($steamUser->getPersonaState());
        $user->setPrimaryClanId($steamUser->getPrimaryClanId());
        $user->setTimeCreated($steamUser->getTimeCreated());
        $user->setPersonaStateFlags($steamUser->getPersonaStateFlags());

        return $user;
    }

    public function createOrUpdateUser(SteamUser $steamUser): User
    {
        $user = $this->findOneBy(['steamId' => $steamUser->getSteamId()]);

        $user = (!$user)
            ? $this->hydrator->hydrate($steamUser)
            : $this->updateBySteamUser($steamUser, $user);

        $this->add($user, true);

        return $user;
    }
}

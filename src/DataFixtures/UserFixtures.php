<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setSteamId($faker->unique()->randomNumber(8))
            ->setCommunityVisibilityState($faker->randomNumber(1))
            ->setProfileState($faker->randomNumber(1))
            ->setPersonaName($faker->name())
            ->setLastLogoff($faker->unixTime())
            ->setProfileUrl($faker->url())
            ->setAvatar($faker->imageUrl())
            ->setAvatarMedium($faker->imageUrl())
            ->setAvatarFull($faker->imageUrl())
            ->setPersonaState($faker->randomNumber(1))
            ->setPersonaStateFlags($faker->randomNumber(1))
            ->setPassword('')
            ->setPrimaryClanId($faker->randomNumber(8))
            ->setTimeCreated($faker->unixTime())
            ->setPersonaStateFlags($faker->randomNumber(1))
            ->setCreatedAt(new \DateTimeImmutable($faker->date()))
        ;

        $manager->persist($user);
        $manager->flush();
    }
}

<?php

namespace App\Tests\Unit\Entity\SteamClient;

use App\Entity\SteamClient\SteamUser;
use PHPUnit\Framework\TestCase;

class SteamClientUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new SteamUser();
        $user->setSteamId('123456789')
                ->setCommunityVisibilityState(3)
                ->setProfileState(1)
                ->setPersonaName('Test')
                ->setLastLogoff(123456789)
                ->setProfileUrl('https://www.test.com')
                ->setAvatar('https://www.test.com/avatar.jpg')
                ->setAvatarMedium('https://www.test.com/avatar_medium.jpg')
                ->setAvatarFull('https://www.test.com/avatar_full.jpg')
                ->setPersonaState(1)
                ->setPrimaryClanId('123456789')
                ->setTimeCreated(123456789)
                ->setPersonaStateFlags(1)
        ;

        $this->assertTrue('123456789' === $user->getSteamId());
        $this->assertTrue(3 === $user->getCommunityVisibilityState());
        $this->assertTrue(1 === $user->getProfileState());
        $this->assertTrue('Test' === $user->getPersonaName());
        $this->assertTrue(123456789 === $user->getLastLogoff());
        $this->assertTrue('https://www.test.com' === $user->getProfileUrl());
        $this->assertTrue('https://www.test.com/avatar.jpg' === $user->getAvatar());
        $this->assertTrue('https://www.test.com/avatar_medium.jpg' === $user->getAvatarMedium());
        $this->assertTrue('https://www.test.com/avatar_full.jpg' === $user->getAvatarFull());
        $this->assertTrue(1 === $user->getPersonaState());
        $this->assertTrue('123456789' === $user->getPrimaryClanId());
        $this->assertTrue(123456789 === $user->getTimeCreated());
        $this->assertTrue(1 === $user->getPersonaStateFlags());
    }

    public function testIsFalse()
    {
        $user = new SteamUser();

        $user->setSteamId('123456789')
                ->setCommunityVisibilityState(3)
                ->setProfileState(1)
                ->setPersonaName('Test')
                ->setLastLogoff(123456789)
                ->setProfileUrl('https://www.test.com')
                ->setAvatar('https://www.test.com/avatar.jpg')
                ->setAvatarMedium('https://www.test.com/avatar_medium.jpg')
                ->setAvatarFull('https://www.test.com/avatar_full.jpg')
                ->setPersonaState(1)
                ->setPrimaryClanId('123456789')
                ->setTimeCreated(123456789)
                ->setPersonaStateFlags(1)
        ;

        $this->assertFalse('1234567891' === $user->getSteamId());
        $this->assertFalse(2 === $user->getCommunityVisibilityState());
        $this->assertFalse(2 === $user->getProfileState());
        $this->assertFalse('Test1' === $user->getPersonaName());
        $this->assertFalse(1234567891 === $user->getLastLogoff());
        $this->assertFalse('https://www.test.com1' === $user->getProfileUrl());
        $this->assertFalse('https://www.test.com/avatar1.jpg' === $user->getAvatar());
        $this->assertFalse('https://www.test.com/avatar_medium1.jpg' === $user->getAvatarMedium());
        $this->assertFalse('https://www.test.com/avatar_full1.jpg' === $user->getAvatarFull());
        $this->assertFalse(2 === $user->getPersonaState());
        $this->assertFalse('1234567891' === $user->getPrimaryClanId());
        $this->assertFalse(1234567891 === $user->getTimeCreated());
        $this->assertFalse(2 === $user->getPersonaStateFlags());
    }

    public function testIsEmpty()
    {
        $user = new SteamUser();

        $this->assertEmpty($user->getCommunityVisibilityState());
        $this->assertEmpty($user->getProfileState());
        $this->assertEmpty($user->getLastLogoff());
        $this->assertEmpty($user->getProfileUrl());
        $this->assertEmpty($user->getPersonaState());
        $this->assertEmpty($user->getPrimaryClanId());
        $this->assertEmpty($user->getTimeCreated());
        $this->assertEmpty($user->getPersonaStateFlags());
    }
}

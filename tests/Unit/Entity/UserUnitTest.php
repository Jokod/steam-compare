<?php

namespace App\Test\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();
        $now  = new \DateTimeImmutable();

        $user->setSteamId('123456789')
                ->setId(1)
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
                ->setRoles(['ROLE_USER'])
                ->setPassword('password')
                ->setCreatedAt($now)
        ;

        $this->assertTrue('123456789' === $user->getSteamId());
        $this->assertTrue(1 === $user->getId());
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
        $this->assertTrue($user->getRoles() === ['ROLE_USER']);
        $this->assertTrue('password' === $user->getPassword());
        $this->assertTrue($user->getCreatedAt() === $now);
        $this->assertTrue($user->getUsername() === $user->getPersonaName());
        $this->assertTrue($user->getUserIdentifier() === $user->getPersonaName());
        $this->assertTrue(null === $user->getSalt());
        $this->assertTrue(null === $user->eraseCredentials());
    }

    public function testIsFalse()
    {
        $user = new User();

        $user->setSteamId('123456789')
                ->setId(1)
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
                ->setRoles(['ROLE_USER'])
                ->setPassword('password')
                ->setCreatedAt(new \DateTimeImmutable())
        ;

        $this->assertFalse('1234567891' === $user->getSteamId());
        $this->assertFalse(2 === $user->getId());
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
        $this->assertFalse($user->getRoles() === ['ROLE_USER1']);
        $this->assertFalse('password1' === $user->getPassword());
        $this->assertFalse($user->getCreatedAt() === new \DateTimeImmutable('2021-01-01'));
        $this->assertFalse($user->getUsername() === $user->getPersonaName() . '1');
        $this->assertFalse($user->getUserIdentifier() === $user->getPersonaName() . '1');
    }

    public function testIsEmpty()
    {
        $user = new User();

        $this->assertEmpty($user->getId());
        $this->assertEmpty($user->getCommunityVisibilityState());
        $this->assertEmpty($user->getProfileState());
        $this->assertEmpty($user->getLastLogoff());
        $this->assertEmpty($user->getProfileUrl());
        $this->assertEmpty($user->getPersonaState());
        $this->assertEmpty($user->getPrimaryClanId());
        $this->assertEmpty($user->getTimeCreated());
        $this->assertEmpty($user->getPersonaStateFlags());
        $this->assertEmpty($user->getSalt());
        $this->assertEmpty($user->eraseCredentials());
    }
}

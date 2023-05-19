<?php

namespace App\Tests\Functional\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityFunctionalTest extends WebTestCase
{
    public function testRedirectToLoginPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseRedirects('/login');
    }

    public function testShouldDisplayLoginPage(): void
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('img[alt="Connexion à Steam"]');
    }

    public function testRedirectToDashboard()
    {
        $client         = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findAll()[0];
        $client->loginUser($testUser);

        $client->request('GET', '/login');
        $this->assertResponseRedirects('/');
    }

    public function testLogout()
    {
        $client = static::createClient();
        $client->request('GET', '/logout');

        $this->assertResponseStatusCodeSame(302);
    }
}

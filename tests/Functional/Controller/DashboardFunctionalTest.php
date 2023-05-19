<?php

namespace App\Tests\Functional\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardFunctionalTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $this->loginUser($client);

        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    private function loginUser(KernelBrowser $client): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findAll()[0];
        $client->loginUser($testUser);
    }
}

<?php

namespace App\Tests\Unit\Security;

use App\Repository\UserRepository;
use App\Security\SteamAuthenticator;
use App\Service\SteamClient;
use App\Service\UserContext;
use Monolog\Test\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class SteamAuthenticatorUnitTest extends TestCase
{
    public function testSupports()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testGetCredentials()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testOnAuthenticationFailure()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testOnAuthenticationSuccess()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testStart()
    {
        $steamClientMock    = $this->createMock(SteamClient::class);
        $routerMock         = $this->createMock(RouterInterface::class);
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userContextMock    = $this->createMock(UserContext::class);

        $class    = new SteamAuthenticator($steamClientMock, $routerMock, $userRepositoryMock, $userContextMock);
        $response = $class->start();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertSame('', $response->getContent());
    }
}

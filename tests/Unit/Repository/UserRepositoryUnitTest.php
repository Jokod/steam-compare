<?php

namespace App\Tests\Functional\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserRepositoryUnitTest extends TestCase
{
    // public function testAdd()
    // {
    //     $entity = new User();

    //     $entityManagerMock = $this->createMock(EntityManagerInterface::class);

    //     /** @var MockObject $entityManagerMock */
    //     $entityManagerMock->expects($this->once())
    //         ->method('persist')
    //         ->with($this->equalTo($entity));

    //     $entityManagerMock->expects($this->never())
    //         ->method('flush');

    //     $repository = new UserRepository($entityManagerMock);
    //     $repository->add($entity);
    // }

    // public function testAddWithFlush()
    // {
    //     $entity = new User();

    //     $entityManagerMock = $this->createMock(EntityManagerInterface::class);

    //     /** @var MockObject $entityManagerMock */
    //     $entityManagerMock->expects($this->once())
    //         ->method('persist')
    //         ->with($this->equalTo($entity));

    //     $entityManagerMock->expects($this->once())
    //         ->method('flush');

    //     $repository = new UserRepository($entityManagerMock);
    //     $repository->add($entity, true);
    // }

    // public function testUpdateBySteamUser()
    // {
    //     $entity = new User();

    //     $entityManagerMock = $this->createMock(EntityManagerInterface::class);

    //     /** @var MockObject $entityManagerMock */
    //     $entityManagerMock->expects($this->once())
    //         ->method('persist')
    //         ->with($this->equalTo($entity));

    //     $entityManagerMock->expects($this->once())
    //         ->method('flush');

    //     $repository = new UserRepository($entityManagerMock);
    //     $repository->updateBySteamUser($entity);
    // }
}

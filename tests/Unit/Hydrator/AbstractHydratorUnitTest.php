<?php

namespace App\Tests\Unit\Hydrator;

use App\Hydrator\HydratorManager;
use PHPUnit\Framework\TestCase;

class AbstractHydratorUnitTest extends TestCase
{
    public function testGetHydratorManager()
    {
        $managerMock = $this->createMock(HydratorManager::class);
        $hydrator    = new TestHydrator($managerMock);

        $result = $hydrator->getHydratorManager();

        $this->assertInstanceOf(HydratorManager::class, $result);
        $this->assertSame($managerMock, $result);
    }
}

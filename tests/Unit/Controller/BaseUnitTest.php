<?php

namespace App\Tests\Functional\Controller;

use App\Controller\BaseController;
use PHPUnit\Framework\TestCase;

class BaseUnitTest extends TestCase
{
    public function testGetSubscribedServices()
    {
        $subscribedServices = BaseController::getSubscribedServices();

        $this->assertIsArray($subscribedServices);
    }
}

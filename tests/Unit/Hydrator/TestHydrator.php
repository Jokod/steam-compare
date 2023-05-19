<?php

namespace App\Tests\Unit\Hydrator;

use App\Entity\User;
use App\Hydrator\AbstractHydrator;

class TestHydrator extends AbstractHydrator
{
    public function hydrate($data): User
    {
        return new User();
    }

    public function supports($result): bool
    {
        return $result instanceof User;
    }
}

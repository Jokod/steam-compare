<?php

namespace App\Hydrator;

abstract class AbstractHydrator implements HydratorInterface
{
    private $manager;

    public function __construct(HydratorManager $manager)
    {
        $this->manager = $manager;
    }

    public function getHydratorManager(): HydratorManager
    {
        return $this->manager;
    }
}

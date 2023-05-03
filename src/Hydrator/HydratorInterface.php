<?php

namespace App\Hydrator;

interface HydratorInterface
{
    /**
     * Hydrate new entity from payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function hydrate($payload);

    /**
     * Is supported entity class.
     *
     * @param mixed $payload
     */
    public function supports($payload): bool;
}
